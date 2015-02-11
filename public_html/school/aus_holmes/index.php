<?php
require_once '../../include/header.php';

$header_obj = new Header();

$header_obj->title_page='ホルムズインスカレッジ ';
$header_obj->description_page='ホルムズインスカレッジ。ワーキングホリデー（ワーホリ）や留学で行ける各種語学学校のご案内です。ワーキングホリデー（ワーホリ）協定国の最新のビザ取得方法や渡航情報などを発信しています。また、ワーキングホリデー（ワーホリ）をされる方向けの各種無料セミナーを開催しています。オーストラリア、ニュージーランド、カナダ、韓国、フランス、ドイツ、イギリス、アイルランド、デンマーク、台湾、香港でワーキングホリデー（ワーホリ）ビザの取得が可能です。ワーキングホリデー（ワーホリ）ビザ以外に学生ビザでの留学などもお手伝い可能です。';

$header_obj->add_css_files='<link href="/school/src/facebox.css" media="screen" rel="stylesheet" type="text/css" />';
$header_obj->add_js_files='<script src="/school/lib/jquery.js" type="text/javascript"></script>
<script src="/school/src/facebox.js" type="text/javascript"></script>
<script type="text/javascript">
jQuery(document).ready(function($) {
$("a[rel*=facebox]").facebox({
loadingImage : "../src/loading.gif",
closeImage   : "../src/closelabel.png"
n})
})
</script>';

$header_obj->full_link_tag=true;

$header_obj->fncMenuHead_imghtml = '<img id="top-mainimg" src="../../images/mainimg/top-mainimg.jpg" alt="" width="970" height="170" />';
$header_obj->fncMenuHead_h1text = 'ホルムズインスカレッジ';

$header_obj->display_header();

?>

	<div id="maincontent">
	  <?php echo $header_obj->breadcrumbs('school','school-aus'); ?>
	  <div id="sitemapbox">

		<table class="school-title">
		<tr>
		<td class="name">
			<a href="http://www.holmes.edu.au/" target="_blank">ホルムズインスカレッジ<br/>（Holmes Colleges）</a>
		</td>
		<td class="kuni">
			<a href="../aus.html"><img src="../../images/flag01.gif"><br/>Australia</a>
		</td>
		</tr>
		</table>

		<div style="height:20px;">&nbsp;</div>

		<img src="p01.jpg" width="80" alt="" style="float:left; padding-right:10px;" />

			<p>
			ホルムズインスカレッジは１９６３年の創立以来、優れたオーストラリアの教育を基準に一般英語コース、ビジネスコースを展開している世界的に評判の高い学校です。
			</p>		

	  </div>

	  <h2 class="sec-title">ホルムズインスカレッジ(Holmes Colleges)の様子</h2>
	  <div id="sitemapbox">
		<table>
		<tr>
			<td><a href="p11_lrg.jpg" rel="facebox"><img src="p11_sml.jpg"></a></td>
			<td width="30px">&nbsp;</td>
			<td><a href="p12_lrg.jpg" rel="facebox"><img src="p12_sml.jpg"></a></td>
		</table>

	  </div>


	  <h2 class="sec-title">Holmesのここが違う！</h2>
	  <div id="sitemapbox">

<Font Size="2">

		キャンパスは全部で５校、あなたの勉強にとても適した場所にあります：<br />
		<b>メルボルン、シドニー、ブリスベン、ゴールドコースト、ケアンズ</b><br />
<br />
		校舎内の雰囲気はとても明るくフレンドリーなスタッフと生徒で溢れています。<br />
<br />
		すべてのキャンパスは市内の中心地にあり、すべてが学校のそばにあります。<br />
		さらにホルムズは全キャンパスが同じカリキュラムで統一されており、<br />
		キャンパス間の移動も簡単に行えます。<br />
<br />
		ホルムズは皆様に英語の上達だけではなく、様々な体験や充実したオーストラリア生活を提供させていただくことをお約束します。<br />
<br />
		さらにはより高度で専門的なプログラムの習得も可能になっております。<br />
		メルボルン上品で、なおかつヨーロッパのような古風な雰囲気を持つメルボルンはオーストラリアで最も住みやすい街として知られています。<br />
<br />
		<span style="color:blue;"><b>メルボルン</b></span><br />
		四季があり、南半球で最も食事が美味しい場所としてもお馴染みです。<br />
<br />
		<span style="color:blue;"><b>シドニー</b></span><br />
		夏季オリンピックが行われ、ハーバーブリッジでお馴染みのシドニー。<br />
		大都会シドニーはすべてが速く、国際的で人と人の間に境界がない素敵な場所です。<br />
		キャンパスは中心地に位置し、タウンホールと駅はすぐ側です。<br />
<br />
		<span style="color:blue;"><b>ブリスベン</b></span><br />
		”サンシャインステート”と呼ばれるクイーンズランドの州都であるブリスベンは英語の勉強に最も適した場所といえるでしょう。さらには観光やお友達とのお出かけにも最適です。<br />
		キャンパスは中心地に位置しており、バス停、駅、フェリー乗り場からすぐです。<br />
<br />
		<span style="color:blue;"><b>ゴールドコースト</b></span><br />
		英語の勉強はパラダイスから徒歩５分以内！！キャンパスはブロードビーチの中心に位置しています。この素晴らしいキャンパスで、最高水準の技術と融合された教育を受けることができます。<br />
<br />
		<span style="color:blue;"><b>ケアンズ</b></span><br />
		一年を通して暖かく、グレートバリアリーフの玄関口として知られているケアンズでは英語の勉強だけでなくダイビングや渓流でのラフティング、バンジージャンプなどアクティビティ満載です。また毎週金曜日の午後には校舎内でバーベキューを始めさまざまなケアンズキャンパス独自のアクティビティも行っております。<br />

<p>&nbsp;</p>
		<div class="school-subtitle">
			ホルムズカレッジとは？
		</div>
<p>&nbsp;</p>
		<p>
<Font Size="2">

		ホルムズカレッジは親切で優しいスタッフによる細かいところまで行き届いた生徒のケア、そして経験豊富な講師陣による英語の技術向上を中心とした充実した内容のレッスンを提供しております。特に当校の講師陣は英語講師としての技術、経験を十分に兼ね備えており、各生徒の目的に合わせて最大限の努力をしてくれるとても頼もしい存在です。当ホルムズカレッジにおける全スタッフ、全講師は皆様のオーストラリア生活が充実したものになるようお手伝いさせていただきます。
	
</font>


<p>&nbsp;</p>
		<div class="school-subtitle">
		“ジョブクラブ”とアクティビティ
		</div>
		<p>&nbsp;</p>
		<p>
<Font Size="2">

		世界中からやってくる人たちと友達になること、そして現地で仕事をすることはワーキングホリデーで海外へと飛び立つ皆様に共通した目的かと思います。そこで当校は皆様に“ジョブクラブ”という特別クラスをご用意しております。この授業では皆様に英語での履歴書の書き方、英語での面接の受け答えの仕方、英語を使ったサービスの仕方など、現地で仕事を得るのに非常に有効な情報をご提供しております。このクラスは参加自由となっておりますので、ご自身のご都合の良い時にどうぞご参加ください。それから、当校のアクティビティは通常毎週金曜日に行われております。学校で生徒、先生とバーベキューをしたり、街中を探検したり、映画を観たりと、内容は実にバラエティに富んでいます。そして更には、ツアーの申し込みも可能です。こちらのツアーも様々なものをご用意しております。そして料金はホルムズならではのスペシャル価格でご案内しております。お気軽に各校の受付にお伺いください。
</font>
		

<p>&nbsp;</p>
		<div class="school-subtitle">
			ホルムズカレッジ ホストファミリー
		</div>
		<p>&nbsp;</p>
		<p>
<Font Size="2">

		現地の家族と一緒に過ごして、現地の生きた生活、生きた英語を体験してみませんか？当校に所属するホストファミリーはみんなとてもフレンドリーで楽しい人たちばかりです。ぜひファミリーとオーストラリアならではの体験をし、素晴らしい思い出をお作りください。それから、当校ではシェアハウスもご案内可能です。「海外で現地の食材を使って自炊してみたい」、「学校の外でもたくさん友達を作りたい」という人にはシェアハウスはもってこいです。校内にある大きな掲示板にはいつも最新の情報が掲示されております。シェアハウスで様々な国の人たちに出会いここでもぜひ素敵な思い出を作ってくださいね。		</p>
</font>
	
		<p>&nbsp;</p>

		<div class="school-subtitle">
			英語プラス…
		</div>
		<p>&nbsp;</p>
		<p>
		ホルムズの一般英語コースは毎週月曜日スタートです。全キャンパスでは一般英語コースと併せて様々なコースをご用意しております。例えば、ビジネスコース、英語＋サーフィン、英語＋ダイビング等… オーストラリアでは様々な体験が無限大にできます。英語の勉強と併せていろんなことにぜひチャレンジしてみてください。		</p>

<p>&nbsp;</p>

		<div class="school-subtitle">
			語学学校ブログ
		</div>
		<p>&nbsp;</p>
		<p>
		現地情報や学校情報が盛りだくさん！
		語学学校Holmes Institute　公式ブログは<font color=red><a href="http://www.jawhm.or.jp/blog/australia/holmes/" title="語学学校Holmes Institute　公式ブログ"><u>こちら</u></a></font>から

<p>&nbsp;</p>
	<div style="height:50px;">&nbsp;</div>

	  </div>
	  </div>

	</div>

  </div>

<?php fncMenuFooter($header_obj->footer_type); ?>

</body>
</html>
