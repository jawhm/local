<?php
//$big_size = array("width='585'" , "height='295'" , "width='380'" , "height='192'");
//$sml_size = array("width='260'" , "height='131'" , "width='400'" , "height='101'");
//$big_size = array("width='585'" , "height='295'" , "width='260'" , "height='131'");
//$sml_size = array("width='380'" , "height='192'" , "width='400'" , "height='101'");

// 1次リリース
$big_size = array("width='585'" , "height='295'" , "width='584'" , "height='145'");
$sml_size = array("width='380'" , "height='192'" , "width='380'" , "height='74'");

// 2次リリース
//$big_size = array("width='585'" , "height='295'" , "width='584'" , "height='145'");
//$sml_size = array("width='585'" , "height='295'" , "width='584'" , "height='145'");

require_once './blog/config.php';

$query = "
select
 b.bnumber as blogid,
 b.bname as blogname,
 i.inumber as itemid,
 i.ititle as title,
 i.ibody as body,
 m.mname as author,
 m.mrealname as authorname,
 i.itime,
 DATE_FORMAT(i.itime,'%Y/%m/%d') as hiduke,
 i.imore as more,
 m.mnumber as authorid,
 m.memail as authormail,
 m.murl as authorurl,
 c.cname as category,
 i.icat as catid,
 i.iclosed as closed,
 b.bshortname
from
 nucleus_member as m,
 nucleus_category as c,
 nucleus_item as i,
 nucleus_blog as b
where
 b.bnumber not in (22, 23)
  and
 i.iblog = b.bnumber
  and
 i.iauthor = m.mnumber
  and
 i.icat = c.catid
  and
 i.idraft = 0
  and
 i.itime <= '" . date('Y-m-d H:i:s') . "'
order by
 i.itime desc
 limit 3
";

$res = sql_query($query);
$blogItems = array();
while($row = sql_fetch_assoc($res))	{
	$row['topurl'] = '/blog/'.$row['bshortname'].'/';
	$blogItems[] = $row;
}

$view_items = array();
foreach ($blogItems as $item) {
	// 画像付表示
	preg_match_all("/<img(.+?)>/", $item['body'], $matches);
	if ($matches[1])	{
		preg_match_all('/src="(.+?)"/', $matches[0][0], $src);
		if ($src[1])	{
			$item['picture'] = '/blog/picoverlay.php?base='.urlencode($src[1][0]).'&over='.urlencode('/blog/images/'.$item['bshortname'].'.png');
		}
	}else{
		$item['picture'] = '/blog/picoverlay.php?base='.urlencode('/blog/images/'.$item['bshortname'].'_default.png').'&over='.urlencode('/blog/images/'.$item['bshortname'].'.png');
	}
	$view_items[] = $item;
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>日本ワーキング・ホリデー協会</title>
<meta name="robots" content="index,follow">
<meta name="googlebot" content="index,follow,archive">

<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta name="format-detection" content="telephone=no">
<link rel="stylesheet" type="text/css" media="screen" href="/sp/css/flexslider.css">
<link rel="stylesheet" type="text/css" media="screen" href="/sp/css/reset.css">
<link rel="stylesheet" type="text/css" media="screen" href="/sp/css/style.css">
<style>
	.snsb {
		overflow: hidden;
		width: 290px;
		margin: 0 auto;
	}
	.snsb li {
		float: left;
		margin-right: 4px;
	}
	.snsb .tweet {
		width: 110px;
	}
	.snsb .googleplusone {
		width: 60px;
	}
	.snsb iframe {
		margin: 0 !important;
	}
</style>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script type="text/javascript" src="/sp/js/jquery.flexslider-min.js"></script>
<script type="text/javascript" charset="utf-8">
  $(window).load(function() {
    $('.flexslider').flexslider({
		animation: "slide",
		animationSpeed: "1500"
		/*
		,
		start: function() {
			var sml_width = parseInt($('.smlBanner').css('width'));
			var sml_height = parseInt($('.smlBanner').css('height'));
			var to_scale = parseInt($('.flexslider li').css('width')) / sml_width;
			$('.smlBanner').css('width', sml_width * to_scale);
			$('.smlBanner').css('height', sml_height * to_scale);
		}
		*/
	});
  });
</script>
</head>

<body id="top">
<div id="fb-root"></div>
<script type="text/javascript">
	(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) {return;}
		js = d.createElement(s); js.id = id; js.async = true;
		js.src = "//connect.facebook.net/ja_JP/all.js#xfbml=1&amp;appId=158074594262625";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));
</script>
<div id="menu"></div>
  <div class="wrapper">
  
    <header>
      <a href="/"><h1>日本ワーキングホリデー協会</h1></a>
      <a class="login" href="/member/"><span>メンバーログイン</span></a>
    </header>
    
    <div class="headBtn">
       <a class="left" href="/seminar"><span>セミナー予約</span></a>
       <a class="right" href="/mem2/register.php"><span>メンバー登録</span></a>
      </ul>  
    </div><!-- /.headBtn -->
	  <?php

	  // The MAX_PATH below should point to the base of your OpenX installation
	  define('MAX_PATH', '/var/www/html/ad');
	  $big_banner = array();
	  $sml_banner = array();
	  if (@include_once(MAX_PATH . '/www/delivery/alocal.php')) {
		  if (!isset($phpAds_context)) {
			  $phpAds_context = array();
		  }

		  $ids = array(155, 151, 159, 160, 161);
		  //$ids = array(155, 151);
		  foreach ($ids as $id) {
			  $phpAds_context = array();
			  $phpAds_raw = view_local('', $id, 0, 0, '', '', '0', $phpAds_context, '');
			  $phpAds_context[] = array('!=' => 'campaignid:'.$phpAds_raw['campaignid']);
			  if (empty($phpAds_raw['html'])) continue;
			  $big_banner[] = str_replace($big_size, $sml_size, $phpAds_raw['html']);
		  }
		  $ids = array(156, 157, 158, 152, 153, 154);
		  foreach ($ids as $id) {
			  $phpAds_context = array();
			  $phpAds_raw = view_local('', $id, 0, 0, '', '', '0', $phpAds_context, '');
			  $phpAds_context[] = array('!=' => 'campaignid:'.$phpAds_raw['campaignid']);
			  $sml_banner[] = str_replace($big_size, $sml_size, $phpAds_raw['html']);
		  }
	  }

	  ?>


	<div class="flexslider keyvisual">
		<ul class="slides">
			<?php
			foreach ($big_banner as $big) {
				echo '<li>' . $big . '</li>';
			}
			?>
      </ul>
    </div><!-- /.keyvisual -->
    
    <section class="topContents">
    	<div>
			<a href="/seminar/seminar"><img src="/sp/images/bnr_seminar.png" alt="毎日開催セミナー"></a>
			<?php
			/*
        <a href="/seminar/seminar.php?num=7439#calendar_start"><img src="/sp/images/bnr_uk.jpg" alt="イギリスセミナー"></a>
        <a href="/seminar/seminar.php?num=6886#calendar_start"><img src="/sp/images/bnr_can.jpg" alt="カナダセミナー"></a>
			*/
			?>
      </div>
		<?php
		/*
    	<div class="seminar">
        <a class="semBtn" href="/seminar"><span>明日・明後日開催予定のセミナー</span></a>
      </div><!-- /.seminar -->
		*/
      ?>
      <div class="mainBtn">
      	<ul>
        	<li><a href="/system.html"><img src="/sp/images/btn_top01.png" alt="ワーキングホリデーについて"></a></li>
          <li><a href="/start.html"><img src="/sp/images/btn_top02.png" alt="出発までの流れ"></a></li>
        </ul>        
        <ul>
        	<li><a href="/katsuyou.html"><img src="/sp/images/btn_top03.png" alt="ワーキングホリデー＆留学サポート"></a></li>
          <li><a href="/office/"><img src="/sp/images/btn_top04.png" alt="アクセス"></a></li>
        </ul>      
      </div><!-- /.mainBtn -->
		<div class="smlBanner">
			<?php echo $sml_banner[0]; ?>
		</div>
    </section><!--/.topContents-->
    
    <section class="blgList mgb10">
    	<h2><span>ワーキングホリデーNEWS</span></h2>
		<?php
		foreach ($view_items as $one) :
		?>
			<div class="article">
				<div class="left">
					<p><?php echo $one['hiduke']; ?></p>
					<a href="/blog/<?php  echo $one['bshortname']; ?>/item/<?php echo $one['itemid']; ?>"><img src="<?php echo $one['picture']; ?>" alt="ブログ画像"></a>
				</div><!-- /.left -->
				<div class="right">
					<p>
						<a href="/blog/<?php  echo $one['bshortname']; ?>/item/<?php echo $one['itemid']; ?>"><span class="title"><?php echo $one['title']; ?></span></a>
						<?php echo mb_substr(strip_tags($one['body']), 0, 20); ?> …
					</p>
					<a href="/blog/<?php  echo $one['bshortname']; ?>/item/<?php echo $one['itemid']; ?>" class="moreBtn">続きを読む</a>
				</div><!-- /.right -->
			</div><!-- /.article -->
		<?php
		endforeach;
		/*
		?>
      <div class="article">
      	<div class="left">
          <p>2014/01/24</p>
          <img src="/sp/images/blog_photo01.jpg" alt="ブログ画像">
        </div><!-- /.left -->
        <div class="right"> 
          <p>
          <span class="title">今から始める留学・ワーホリ準備</span>
          今年の春に出発を考えていらっしゃる皆様 準備は進んでいますか？ …
          </p>
          <a href="" class="moreBtn">続きを読む</a>
        </div><!-- /.right -->
      </div><!-- /.article -->
      
      <div class="article">
      	<div class="left">
          <p>2014/01/24</p>
          <img src="/sp/images/blog_photo02.jpg" alt="ブログ画像">
        </div><!-- /.left -->
        <div class="right"> 
          <p>
          <span class="title">今から始める留学・ワーホリ準備</span>
          今年の春に出発を考えていらっしゃる皆様 準備は進んでいますか？ …
          </p>
          <a href="" class="moreBtn">続きを読む</a>
        </div><!-- /.right -->
      </div><!-- /.article -->
      
      <div class="article last">
      	<div class="left">
          <p>2014/01/24</p>
          <img src="/sp/images/blog_photo03.jpg" alt="ブログ画像">
        </div><!-- /.left -->
        <div class="right"> 
          <p>
          <span class="title">今から始める留学・ワーホリ準備</span>
          今年の春に出発を考えていらっしゃる皆様 準備は進んでいますか？ …
          </p>
          <a href="" class="moreBtn">続きを読む</a>
        </div><!-- /.right -->
      </div><!-- /.article -->
		<?php
		*/
		?>
			<div class="pad10">
    		<a class="btnPink" href="/blog/"><span>ワーキングホリデー協会ブログ一覧をみる</span></a>
      </div>
		<div class="smlBanner">
			<?php echo $sml_banner[1]; ?>
		</div>
    </section>
    
    <section class="menuBox menu1">
    	<h2><span>ワーキングホリデーについて知ろう</span></h2>
      <div>
      	<a href="/system.html"><span>ワーキングホリデー制度について</span></a>
        <a href="/start.html"><span>ワーキングホリデーへの道</span></a>
      </div>
    </section>
    
    <section class="menuBox menu2">
    	<h2><span>ワーキングホリデー協会を活用しよう</span></h2>
      <div>
      	<a href="/katsuyou.html"><span>ワーホリ協会活用ガイド</span></a>
        <a href="/mem/"><span>ワーホリ成功のためのフルサポート</span></a>
      </div>    	
    </section>
    
    <section class="menuBox menu3">
    	<h2 class="mgb15"><span>ワーキングホリデー協定国（ビザ情報）</span></h2>
      <ul class="visaMenu">
      	<li><a href="/visa/v-aus.html"><img src="/sp/images/visa_aus.png" alt="オーストラリア"></a></li>
        <li><a href="/visa/v-can.html"><img src="/sp/images/visa_canada.png" alt="カナダ"></a></li>
        <li><a href="/visa/v-nz.html"><img src="/sp/images/visa_newz.png" alt="ニュージーランド"></a></li>
      </ul>
      <ul class="visaMenu">
      	<li><a href="/visa/v-uk.html"><img src="/sp/images/visa_england.png" alt="イギリス"></a></li>
        <li><a href="/visa/v-ire.html"><img src="/sp/images/visa_eire.png" alt="アイルランド"></a></li>
        <li><a href="/visa/v-fra.html"><img src="/sp/images/visa_france.png" alt="フランス"></a></li>
      </ul>
      <ul class="visaMenu">
      	<li><a href="/visa/v-deu.html"><img src="/sp/images/visa_deuts.png" alt="ドイツ"></a></li>
        <li><a href="/visa/v-dnk.html"><img src="/sp/images/visa_den.png" alt="デンマーク"></a></li>
        <li><a href="/visa/v-nor.html"><img src="/sp/images/visa_nor.png" alt="ノルウェー"></a></li>
      </ul>
      <ul class="visaMenu">
      	<li><a href="/visa/v-kor.html"><img src="/sp/images/visa_korea.png" alt="韓国"></a></li>
        <li><a href="/visa/v-ywn.html"><img src="/sp/images/visa_taiwan.png" alt="台湾"></a></li>
        <li><a href="/visa/v-hkg.html"><img src="/sp/images/visa_hong.png" alt="香港"></a></li>
      </ul>
    </section>
    
    <div class="seminar mgb20">
      	<a href="/seminar/seminar"><img src="/sp/images/bnr_seminar.png"></a>
    </div><!-- /.seminar -->  
    
    <section class="menuBox menu4">
    	<h2><span>お役立ち情報</span></h2>
      <div>
      	<a href="/info.html"><span>お役立ちリンク集</span></a>
        <a href="/school.html"><span>海外語学学校</span></a>
        <a href="/blog/"><span>ワーホリ＆留学ブログ</span></a>
      </div>
    </section>
    
    <div class="banArea mgb20">
		<div class="smlBanner">
			<?php echo $sml_banner[2]; ?>
		</div>

		<div class="advbox03" style="width: 300px; height: 69px; margin: 0 auto; padding-bottom: 30px;">
			<?php
			// AIU2
			define('MAX_PATH', '/var/www/html/ad');
			if (@include_once(MAX_PATH . '/www/delivery/alocal.php')) {
				if (!isset($phpAds_context)) {
					$phpAds_context = array();
				}
				// function view_local($what, $zoneid=0, $campaignid=0, $bannerid=0, $target='', $source='', $withtext='', $context='', $charset='')
				$phpAds_raw = view_local('', 97, 0, 0, '', '', '0', $phpAds_context, '');
			}
			echo $phpAds_raw['html'];
			// <a href=""><img class="mgb10" src="/sp/images/bnr_aiu.jpg" alt="AIUの海外留学保険"></a>
			// <br/><span style="font-size:8pt;">AIU保険会社のサイトへジャンプします</span>
			?>

		</div>



		<div style="width: 214px; height: 121px; margin: 0 auto;">
		<?php
		// A01
		define('MAX_PATH', '/var/www/vhosts/jawhm.or.jp/httpdocs/ad');
		if (@include_once(MAX_PATH . '/www/delivery/alocal.php')) {
			if (!isset($phpAds_context)) {
				$phpAds_context = array();
			}
			// function view_local($what, $zoneid=0, $campaignid=0, $bannerid=0, $target='', $source='', $withtext='', $context='', $charset='')
			$phpAds_raw = view_local('', 29, 0, 0, '', '', '0', $phpAds_context, '');
		}
		// $phpAds_raw['html'];
		echo $phpAds_raw['html'];
		// 		<a href=""><img class="cashBtn" src="/sp/images/bnr_cash.jpg" alt="海外専用外貨プリペイドカード"></a>
		?>
		</div>

    </div>  

    <footer>
    	<div class="center">
      	<a href="">TOPにもどる</a> / <a href="">PC View</a>
      </div>
      
      <div class="inBox">
		  <ul class="snsb">
			  <li><div class="fb-like" data-href="http://www.jawhm.or.jp/" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div></li>
			  <li class="tweet"><a href="https://twitter.com/share" class="twitter-share-button" data-url="http://www.jawhm.or.jp/">Tweet</a></li>
			  <li class="googleplusone"><div class="g-plusone" data-size="medium" data-href="http://www.jawhm.or.jp/"></div></li>
		  </ul>
		  <?php // <img src="/sp/images/img_sns.png" alt="SNSボタン"> ?>
		  <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
		  <!-- +1 ボタン を表示したい位置に次のタグを貼り付けてください。 -->
		  <!-- 最後の +1 ボタン タグの後に次のタグを貼り付けてください。 -->
		  <script type="text/javascript">
			  window.___gcfg = {lang: 'ja'};
			  (function() {
				  var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
				  po.src = 'https://apis.google.com/js/platform.js';
				  var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
			  })();
		  </script>
        <p class="small">Copyright© JAPAN Association for Working Holiday Makers<br>All right reserved.</p>
      </div> 
    </footer>
      
  </div><!--/.wrapper-->
  
  
	<script type="text/javascript">
  //ページ内リンク、#非表示。スムーズスクロール
    $('a[href^=#]').click(function(){
      var speed = 800;
      var href= $(this).attr("href");
      var target = $(href == "#" || href == "" ? 'html' : href);
      var position = target.offset().top;
      $("html, body").animate({scrollTop:position}, speed, "swing");
      return false;
    });
  </script>
</body>
</html>