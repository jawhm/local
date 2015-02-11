<?php
require_once '../include/header.php';

$header_obj = new Header();

$header_obj->fncFacebookMeta_function=true;

$header_obj->title_page='アクセス';
$header_obj->description_page='ワーキングホリデー（ワーホリ）協会の各オフィスのご案内です。ワーキングホリデー（ワーホリ）協定国の最新のビザ取得方法や渡航情報などを発信しています。また、ワーキングホリデー（ワーホリ）をされる方向けの各種無料セミナーを開催しています。オーストラリア、ニュージーランド、カナダ、韓国、フランス、ドイツ、イギリス、アイルランド、デンマーク、台湾、香港でワーキングホリデー（ワーホリ）ビザの取得が可能です。ワーキングホリデー（ワーホリ）ビザ以外に学生ビザでの留学などもお手伝い可能です。';

$header_obj->fncMenuHead_imghtml = '<img id="top-mainimg" src="/images/mainimg/access-mainimg.gif" alt="" width="970" height="170" />';
$header_obj->fncMenuHead_h1text = '日本ワーキング・ホリデー協会オフィスへのアクセス';

$header_obj->add_js_files='<script type="text/javascript" src="jquery-ui.min.js"></script>
<script type="text/javascript" src="jquery.flip.min.js"></script>
<script type="text/javascript" src="script.js"></script>';
$header_obj->add_css_files='<link rel="stylesheet" type="text/css" href="styles.css" />';

$header_obj->display_header();

?>

	<div id="maincontent">
	  <?php echo $header_obj->breadcrumbs(); ?>
	  <h2 class="sec-title">日本ワーキングホリデー協会　各オフィスへのご案内</h2>

	<?php if($header_obj->mobilepage)	{ ?>
	<?php }else{	?>
	<?php } ?>

		<div style="margin:30px 0 0 80px; padding-top:20px;">
			<img src="/office/japan.png" usemap="#japan">
			<map name="japan">
				<area shape="rect" coords="323,238,462,303" href="/office/tokyo/" alt="東京オフィス">
				<area shape="rect" coords="141,263,278,307" href="/office/osaka/" alt="大阪オフィス">
				<area shape="rect" coords="215,326,383,383" href="/office/nagoya/" alt="名古屋オフィス">
				<area shape="rect" coords="0,258,123,315" href="/office/fukuoka/" alt="福岡オフィス">
				<area shape="rect" coords="11,371,160,420" href="/office/okinawa/" alt="沖縄オフィス">
			</map>
		</div>

	<a href="/office/tokyo/"><h3 class="table-base-title" style="font-size:13pt;" id="tokyo-office">東京オフィス（新宿本店）</h3></a>
	<a href="/office/osaka/"><h3 class="table-base-title" style="font-size:13pt;" id="tokyo-office">大阪オフィス</h3></a>
	<a href="/office/nagoya/"><h3 class="table-base-title" style="font-size:13pt;" id="tokyo-office">名古屋オフィス</h3></a>
	<a href="/office/fukuoka/"><h3 class="table-base-title" style="font-size:13pt;" id="tokyo-office">福岡オフィス</h3></a>
	<a href="/office/okinawa/"><h3 class="table-base-title" style="font-size:13pt;" id="tokyo-office">沖縄オフィス</h3></a>


	  <h2 class="sec-title">ワーホリや留学の様子</h2>



<?php
$sponsors = array(
	array('01','世界中を飛び回れ！！',''),
	array('02','ホームステイは触れ合いがいっぱい',''),
	array('03','外国の方の砂遊びはピラミッド！？',''),
	array('04','ワーホリで世界中の友達を作ろう！！',''),
	array('05','友達は多い方がよし',''),
	array('06','ズッキーニ美味しく頂きました',''),
	array('07','休日の基本はバーベーキュー',''),
	array('08','冬のカナダはスノボし放題だね',''),
	array('09','大人っぽいですが高校の卒業式です',''),
	array('10','週末はパーティーが多いかな',''),
	array('11','友達１００人できるかな',''),
	array('12','学校で勉強しようね',''),
);
shuffle($sponsors);
?>

	<div class="sponsorListHolder">
        <?php
		$idx=0;
		foreach($sponsors as $company)
		{
			$idx++;
			echo'
			<div class="sponsor" title="'.$company[0].'">
				<div class="sponsorFlip">
					<img src="/office/filpimage/'.$company[0].'-a.png" alt="'.$company[1].'" />
					'.$company[2].'
				</div>
				<div class="sponsorData">
					<div class="sponsorDescription">
						<img src="/office/filpimage/'.sprintf("%02d",$idx).'-b.png" alt="'.$company[1].'" />
					</div>
				</div>
			</div>
			
			';
		}
	?>
    	<div class="clear"></div>
	</div>

	  <div class="top-move">
	    <p><a href="#header">▲ページのＴＯＰへ</a></p>
	  </div>
	</div>
  </div>
  </div>

<?php fncMenuFooter($header_obj->footer_type); ?>

</body>
</html>