<?php
require_once '../../../include/header.php';

$header_obj = new Header();

$header_obj->title_page='アイエルエスシー（ＩＬＳＣ）';
$header_obj->description_page='オーストラリアの学校。ワーキングホリデー（ワーホリ）や留学で行ける各種語学学校のご案内です。ワーキングホリデー（ワーホリ）協定国の最新のビザ取得方法や渡航情報などを発信しています。また、ワーキングホリデー（ワーホリ）をされる方向けの各種無料セミナーを開催しています。オーストラリア、ニュージーランド、カナダ、韓国、フランス、ドイツ、イギリス、アイルランド、デンマーク、台湾、香港でワーキングホリデー（ワーホリ）ビザの取得が可能です。ワーキングホリデー（ワーホリ）ビザ以外に学生ビザでの留学などもお手伝い可能です。';
$header_obj->add_js_files='<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.min.js"></script>
<script type="text/javascript" src="/school/voice/jquery.flip.min.js"></script>
<script type="text/javascript" src="/school/voice/script.js"></script>';
$header_obj->add_css_files='<link rel="stylesheet" type="text/css" href="/school/voice/styles.css" />';

$header_obj->fncMenuHead_imghtml = '<img id="top-mainimg" src="../../../images/mainimg/school-mainimg.jpg" alt="" width="970" height="170" />';
$header_obj->fncMenuHead_h1text = '留学・ワーホリ経験者からの声（ＩＬＳＣ）';
$header_obj->fncFacebookMeta_function=true;

$header_obj->display_header();

?>
	<div id="maincontent">
	  <?php echo $header_obj->breadcrumbs('school','school-voice'); ?>

	  <h2 class="sec-title">アイエルエスシー　からの声</h2>
	  <div id="sitemapbox">

    <div class="school-subtitle">
		卒業生　クボウチアイさん
	</div>
	<p>&nbsp;</p>

<p class="text01">

</p>


<p>&nbsp;</p>
<p class="text02">
<img src="../img/q03.gif">
 どういうきっかけで留学を決意しましたか？<br/>
<img src="../img/q03.gif">
 大学４年生で就職活動をはじめるときに、ずっと憧れていた海外留学をこのまましないで卒業してもいいのか？という迷いがありました。同時に、これから社会に出ようとする自分自身に対しても自信が持てませんでした。こんな武器も長所も見えてこない自分が、就職活動、ましてその先の社会という場で戦っていけるのか不安でした。そんな自分を見つめなおすことも目的として、時間が欲しいと思い、両親を説得しました。勿論、語学などスキルの面で習得できることもたくさんあると思ったのでそれもきっかけの一部ではあります。
</p>

<p>&nbsp;</p>
<p class="text02">
<img src="../img/q03.gif">
 留学中どんなことをしましたか？<br/>
<img src="../img/q03.gif">
 通算で１年と１ヶ月ILSCに所属したと記憶しています。その間、ＴＯＥＩＣ対策やＩＥＬＴＳ対策、general Englishなど含め通常の語学学校での授業は一通りすべて、あとは英語教育に関するTESOLを履修し、そして最後にBusiness Diplomaと、興味あることは全て挑戦しました。せっかく掴んだチャンス、応援してくれる周囲のためにも私のためにも無駄にはしないと必死でした。時々ガス欠で旅行に行って羽を伸ばしたり、友人と飲んだり息ぬきもきちんとしたのがよかったと思います。日本の大学でやっていた少林寺拳法もＡＵＳの道場を見つけて練習に参加させてもらい、とにかくネイティブと交流する機会を作るようにしたのも英語上達を助けてくれたし、交友関係も築くことができ、心に残る人との出会いも多くもてました。
&nbsp;<br/>
</p>
<center>
<p class="text01">
<img  class="format-voice" src="./p1.jpg">
</p>
</center>

<p>&nbsp;</p>
<p class="text02">
<img src="../img/q03.gif">
 どのように就職活動に生かすことができて、どんな就職ができましたか？<br/>
<img src="../img/q03.gif">
 自分に自信がもてたこと。何よりもこれにつきると思います。海外の何も知らない、誰も知らない場所に乗り込んでいって、そこで大切な思い出を作り、ブリスベンが自分の人生にとってかけがえない場所と呼べるようになって帰ってきたというその事実にまず背中を押されています。<br/>
就職活動では、能力として見につけた英語やビジネスディプロマなどをアピールしました。しかし、そういった点数や資格だけでは就職はできなかったと思います。やっぱり、何事も積極的に挑戦する姿勢を最後に評価していただけたと思います。そんな粘り強さや前向きさをかっていただき、来春より地元県庁にて公務員として働くこととなりました。またゼロからのスタートですが、あのブリスベンに到着した日の気持ちを思い出して、ひたむきに頑張っていこうと思っています。
</p>


<p class="text01">
&nbsp;<br/>
このクボウチアイさんが通った、<a href="/school/aus_ilsc/">アイエルエスシーの情報はこちらから</a>
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