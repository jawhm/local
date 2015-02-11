<?php
	//
	// ロールオーバー用ＪＳスクリプト
	//
	function fncMenuScript()	
	{	
?>
	<script>
		jQuery(function(){
			 jQuery('a img').hover(function(){
				jQuery(this).attr('src', jQuery(this).attr('src').replace('_off', '_on'));
				  }, function(){
					 if (!jQuery(this).hasClass('currentPage')) {
					 jQuery(this).attr('src', jQuery(this).attr('src').replace('_on', '_off'));
				}
		   });
		
			var images = jQuery("img");
			for(var i=0; i < images.size(); i++) {
				if(images.eq(i).attr("src").match("/ad/www/images/.")) {
					jQuery("img").eq(i).hover(function() {
						jQuery(this).css('opacity', '0.6');
					}, function() {
						jQuery(this).css('opacity', '1');
					});
				}
			}
		
		});
	</script>
    
<?php
	} //end fncMenuScrip function

//
// Facebook用メタ
//
	function fncFacebookMeta()	
	{
?>
    <meta property="og:title" content="ワーキングホリデー・留学の事なら日本ワーキングホリデー協会">
    <meta property="og:type" content="website">
    <meta property="og:url" content="http://<? print $_SERVER["QUERY_STRING"]; ?>"></meta>
    <meta property="og:image" content="http://www.jawhm.or.jp/images/katsuyou_step5_image.jpg">
    <meta property="og:site_name" content="日本ワーキング・ホリデー協会">
    <meta property="og:locale" content="ja_JP" />
    <link rel="shortcut icon" href="http://www.jawhm.or.jp/images/favicon.ico" type="image/x-icon" />
<?php
	}//end fncFacebookMeta function


//
// ヘッダー定義
//
	function fncMenuHead($imghtml, $h1_text='')	
	{
?>
    <div id="fb-root"></div>
    
    <script type="text/javascript">
		(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) {return;}
		  js = d.createElement(s); js.id = id;
		  js.src = "//connect.facebook.net/ja_JP/all.js#xfbml=1&appId=158074594262625";
		  fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
    
    </script>
    
    <div id="contactable"><!-- contactable html placeholder --></div>
    
    <script type="text/javascript" src="/js/feedback/jquery.validate.pack.js"></script>
    <script type="text/javascript" src="/js/feedback/jquery.contactable.js"></script>
    <link rel="stylesheet" href="/js/feedback/contactable.css" type="text/css" />
    
    <script type="text/javascript">
		$(function(){$('#contactable').contactable({subject: 'feedback URL:'+location.href});});
    </script>
    
    <div id="header" style="position:relative;">
        <h1><?php echo $h1_text; ?></h1>
	<div id="topimg">
		<a href="/" alt="一般社団法人日本ワーキング・ホリデー協会" title="一般社団法人日本ワーキング・ホリデー協会">
			<img src="/images/h1-logo.jpg" alt="日本ワーキングホリデー協会" />
		</a>
	</div>
        <h2><a href="/member"><img src="/images/menu/member_off.gif" alt="日本ワーキングホリデー協会のサービスを利用する"></a></h2>
        <div id="utility-nav">
            <ul>
              <li class="u-nav01"><a href="/">日本語</a></li>
              <li class="u-nav02"><a href="/eng/">英語</a></li>
              <li class="u-nav03"><a href="http://i.jawhm.or.jp/">携帯</a></li>
            </ul>
        </div>
        <?php echo $imghtml; ?>
        <div id="social_tool" style="position:absolute; top:100px; left:620px;">
            <table><tr>
            <td style="vertical-align:top;">
                <div class="fb-like" data-send="false" data-layout="button_count" data-width="110" data-show-faces="false" data-font="arial"></div>
            </td>
            <td style="vertical-align:top;">
                <a href="https://twitter.com/share" class="twitter-share-button" data-count="horizontal" data-via="GoStudyEnglish">Tweet</a><script type="text/javascript" src="//platform.twitter.com/widgets.js"></script>
            </td>
            <td style="vertical-align:top;">
                <g:plusone></g:plusone>
            </td>
            </tr></table>
        </div>
    </div>
<?php
	}//end fncMenuHead function


	//
	// ヘッダー定義（リンクなし
	//
	function fncMenuHead_nolink($imghtml, $h1_text='')	
	{
?>
    <div id="header" style="position:relative;">
        <h1><?php echo $h1_text; ?></h1>
	<div id="topimg">
		<a href="/" alt="一般社団法人日本ワーキング・ホリデー協会" title="一般社団法人日本ワーキング・ホリデー協会">
			<img src="/images/h1-logo.jpg" alt="日本ワーキングホリデー協会" />
		</a>
	</div>
	<div style="height:50px;"></div>
        <?php echo $imghtml; ?>
    </div>
<?php
	}//end fncMenuHead_nolink function


	//
	// 左サイドメニュー（ＴＯＰ用）homepage only
	//
	function fncMenubar_top($msg)	
	{
?>
        <div id="global-nav" style="position:relative;">
            <div class="g-n-sec02">
                <ul id="g-n-main01">
                    <li class="lh_top">
					<?php
                      //<!--/* OpenX Local Mode Tag v2.8.8 */-->
                    
                      // The MAX_PATH below should point to the base of your OpenX installation
                      define('MAX_PATH', '/var/www/html/ad');
					  
                      if (@include_once(MAX_PATH . '/www/delivery/alocal.php')) 
					  {
                        if (!isset($phpAds_context)) 
						{
                          $phpAds_context = array();
                        }
                        // function view_local($what, $zoneid=0, $campaignid=0, $bannerid=0, $target='', $source='', $withtext='', $context='', $charset='')
                        $phpAds_raw = view_local('', 122, 0, 0, '', '', '0', $phpAds_context, '');
                        $phpAds_context[] = array('!=' => 'bannerid:'.$phpAds_raw['bannerid']);
                      }
                      echo $phpAds_raw['html'];
                    ?>
                    </li>
                    <li class="lh_block">&nbsp;</li>
        
                    <li class="lh_top"><img src="/images/menu/sep_wh.gif" alt="ワーキング・ホリデーについて知りたい"></li>
                    <li class="lh_none"><a href="/system.html"><img src="/images/menu/system_off.gif" alt="ワーキング・ホリデー制度について"></a></li>
                    <li class="lh_none"><a href="/start.html"><img src="/images/menu/start_off.gif" alt="はじめてのワーキング・ホリデー"></a></li>
                    <li class="lh_block"><a href="/visa/visa_top.html"><img src="/images/menu/visa_off.gif" alt="ワーキング・ホリデー協定国（ビザ情報）"></a></li>
        
                    <li class="lh_top"><img src="/images/menu/sep_jawhm.gif" alt="協会について知りたい"></li>
                    <li class="lh_none"><a href="/about.html"><img src="/images/menu/about_off.gif" alt="日本ワーキング・ホリデー協会について"></a></li>
                    <li class="lh_block"><a href="/katsuyou.html"><img src="/images/menu/katsuyou_off.gif" alt="日本ワーキング・ホリデー協会活用ガイド"></a></li>
        
                    <li class="lh_top"><img src="/images/menu/sep_support.gif" alt="協会のサポートを受けたい"></li>
                    <li class="lh_none"><a href="/mem"><img src="/images/menu/mem_off.gif" alt="日本ワーキング・ホリデー協会のサポート内容（メンバー登録）"></a></li>
                    <li class="lh_none"><a href="/seminar.html"><img src="/images/menu/seminar_off.gif" alt="無料セミナー"></a></li>
                    <li class="lh_none"><a href="/kouenseminar.php"><img src="/images/menu/kouen_off.gif" alt="講演セミナー"></a></li>
                    <li class="lh_none"><a href="/event.html"><img src="/images/menu/event_off.gif" alt="イベントカレンダー"></a></li>
                    <li class="lh_none"><a href="/return.html"><img src="/images/menu/return_off.gif" alt="帰国後のサポート"></a></li>
                    <li class="lh_none"><a href="/qa.html"><img src="/images/menu/qa_off.gif" alt="よくある質問"></a></li>
                    <li class="lh_none"><a href="/trans.html"><img src="/images/menu/trans_off.gif" alt="翻訳サービス"></a></li>
                    <li class="lh_block"><a href="/gogaku-spec.html"><img src="/images/menu/gogaku_off.gif" alt="語学講座"></a></li>
        
                    <li class="lh_top"><img src="/images/menu/sep_info.gif" alt="お役立ち情報"></li>
                    <li class="lh_none"><a href="/info.html"><img src="/images/menu/info_off.gif" alt="お役立ちリンク集"></a></li>
                    <li class="lh_none"><a href="/school.html"><img src="/images/menu/school_off.gif" alt="語学学校（海外・国内）"></a></li>
                    <li class="lh_none"><a href="/support.html"><img src="/images/menu/support_off.gif" alt="サポート機関"></a></li>
                    <li class="lh_none"><a href="/service.html"><img src="/images/menu/service_off.gif" alt="サービス（保険・アコモデーション等）"></a></li>
                    <li class="lh_sep"><a href="/company.html"><img src="/images/menu/company_off.gif" alt="会員企業一覧（企業会員について）"></a></li>
                    <li class="lh_sep"><a href="/attention.html"><img src="/images/menu/attention_off.gif" alt="外国人ワーキング・ホリデー青年"></a></li>
        
                    <li class="lh_sep"><a href="/jobboard.html"><img src="/images/menu/jobboard_off.gif" alt="jobboard"></a></li>
        
                    <li class="lh_block"><a href="/access.html"><img src="/images/menu/access_off.gif" alt="アクセス（東京本部）"></a></li>
        
                    <li class="lh_top"><img src="/images/menu/sep_com.gif" alt="協賛企業を求めています"></li>
                    <li class="lh_none"><a href="/mem-com.html"><img src="/images/menu/mem_com_off.gif" alt="企業会員について（会員制度ご紹介・意義・メリット）"></a></li>
                    <li class="lh_sep"><a href="/adv.html"><img src="/images/menu/adv_off.gif" alt="広告掲載のご案内"></a></li>
                    <li class="lh_sep"><a href="/volunteer.html"><img src="/images/menu/volunteer_off.gif" alt="ボランティア・インターン募集"></a></li>
                    <li class="lh_none"><a href="/privacy.html"><img src="/images/menu/privacy_off.gif" alt="個人情報の取り扱い"></a></li>
                    <li class="lh_none"><a href="/about.html#deal"><img src="/images/menu/deal_off.gif" alt="特定商取引に関する表記"></a></li>
                    <li class="lh_none"><a href="/sitemap.html"><img src="/images/menu/sitemap_off.gif" alt="サイトマップ"></a></li>
                </ul>
            </div>
            <div class="g-n-sec02">
                <ul id="g-n-main01">
        
                    <li style="margin-top:-35px; padding-left:3px;">
                        <a  href="../seminar.html" onclick="javascript: _gaq.push(['_trackPageview' , '/banner_seminar_left/']);"><img src="/images/semi_bottombanner_off.jpg" width="220"></a><br/>
                    </li>
        
                    <li style="margin-top:10px; margin-left:3px; width:220px; height:80px;">
					<?php
                        // B01
                      define('MAX_PATH', '/var/www/html/ad');
                      if (@include_once(MAX_PATH . '/www/delivery/alocal.php')) 
					  {
                        if (!isset($phpAds_context)) 
						{
                          $phpAds_context = array();
                        }
                        // function view_local($what, $zoneid=0, $campaignid=0, $bannerid=0, $target='', $source='', $withtext='', $context='', $charset='')
                        $phpAds_raw = view_local('', 1, 0, 0, '', '', '0', $phpAds_context, '');
                        $phpAds_context[] = array('!=' => 'bannerid:'.$phpAds_raw['bannerid']);
                      }
                      echo $phpAds_raw['html'];
                    ?>
                    </li>
                    <li style="margin-top:10px; margin-left:3px; width:220px; height:80px;">
					<?php
                        // B02
                      define('MAX_PATH', '/var/www/html/ad');
                      if (@include_once(MAX_PATH . '/www/delivery/alocal.php')) 
					  {
                        if (!isset($phpAds_context)) 
						{
                          $phpAds_context = array();
                        }
                        // function view_local($what, $zoneid=0, $campaignid=0, $bannerid=0, $target='', $source='', $withtext='', $context='', $charset='')
                        $phpAds_raw = view_local('', 2, 0, 0, '', '', '0', $phpAds_context, '');
                        $phpAds_context[] = array('!=' => 'bannerid:'.$phpAds_raw['bannerid']);
                      }
                      echo $phpAds_raw['html'];
                    ?>
                    </li>
                    <li style="margin-top:10px; margin-left:3px; width:220px; height:80px;">
					<?php
                        // B03
                      define('MAX_PATH', '/var/www/html/ad');
                      if (@include_once(MAX_PATH . '/www/delivery/alocal.php')) 
					  {
                        if (!isset($phpAds_context)) 
						{
                          $phpAds_context = array();
                        }
                        // function view_local($what, $zoneid=0, $campaignid=0, $bannerid=0, $target='', $source='', $withtext='', $context='', $charset='')
                        $phpAds_raw = view_local('', 3, 0, 0, '', '', '0', $phpAds_context, '');
                        $phpAds_context[] = array('!=' => 'bannerid:'.$phpAds_raw['bannerid']);
                      }
                      echo $phpAds_raw['html'];
                    ?>
                    </li>
        
                    <li style="margin-top:20px; padding-left:10px;">
					<?php
                        // C01
                      define('MAX_PATH', '/var/www/html/ad');
                      if (@include_once(MAX_PATH . '/www/delivery/alocal.php')) 
					  {
                        if (!isset($phpAds_context))
						{
                          $phpAds_context = array();
                        }
                        // function view_local($what, $zoneid=0, $campaignid=0, $bannerid=0, $target='', $source='', $withtext='', $context='', $charset='')
                        $phpAds_raw = view_local('', 30, 0, 0, '', '', '0', $phpAds_context, '');
                      }
                      echo $phpAds_raw['html'];
                    ?>
                    </li>
        
                    <li style="margin-top:10px; padding-left:3px;">
					<?php
                        // C02
                      define('MAX_PATH', '/var/www/html/ad');
                      if (@include_once(MAX_PATH . '/www/delivery/alocal.php')) 
					  {
                        if (!isset($phpAds_context)) 
						{
                          $phpAds_context = array();
                        }
                        // function view_local($what, $zoneid=0, $campaignid=0, $bannerid=0, $target='', $source='', $withtext='', $context='', $charset='')
                        $phpAds_raw = view_local('', 31, 0, 0, '', '', '0', $phpAds_context, '');
                      }
                      echo $phpAds_raw['html'];
                    ?>
                    </li>
                </ul>
            </div>

			<?php echo $msg;	?>

        </div><!--global-navEND-->
        
<?php
	} //end fncMenubar_top function

	
	//
	// 左サイドメニュー（全体用）others pages 
	//
	function fncMenubar($msg = '')	
	{
?>
        <div id="global-nav" style="position:relative;">
        <div class="g-n-sec02">
            <ul id="g-n-main01">
                <li class="lh_top">
				<?php
				  //<!--/* OpenX Local Mode Tag v2.8.8 */-->
				
				  // The MAX_PATH below should point to the base of your OpenX installation
				  define('MAX_PATH', '/var/www/html/ad');
				  if (@include_once(MAX_PATH . '/www/delivery/alocal.php')) 
				  {
					if (!isset($phpAds_context)) 
					{
					  $phpAds_context = array();
					}
					// function view_local($what, $zoneid=0, $campaignid=0, $bannerid=0, $target='', $source='', $withtext='', $context='', $charset='')
					$phpAds_raw = view_local('', 122, 0, 0, '', '', '0', $phpAds_context, '');
					$phpAds_context[] = array('!=' => 'bannerid:'.$phpAds_raw['bannerid']);
				  }
				  echo $phpAds_raw['html'];
				?>
                </li>
                <li class="lh_block">&nbsp;</li>
    
                <li class="lh_top"><img src="/images/menu/sep_wh.gif" alt="ワーキング・ホリデーについて知りたい"></li>
                <li class="lh_none"><a href="/system.html"><img src="/images/menu/system_off.gif" alt="ワーキング・ホリデー制度について"></a></li>
                <li class="lh_none"><a href="/start.html"><img src="/images/menu/start_off.gif" alt="はじめてのワーキング・ホリデー"></a></li>
                <li class="lh_block"><a href="/visa/visa_top.html"><img src="/images/menu/visa_off.gif" alt="ワーキング・ホリデー協定国（ビザ情報）"></a></li>
    
                <li class="lh_top"><img src="/images/menu/sep_jawhm.gif" alt="協会について知りたい"></li>
                <li class="lh_none"><a href="/about.html"><img src="/images/menu/about_off.gif" alt="日本ワーキング・ホリデー協会について"></a></li>
                <li class="lh_block"><a href="/katsuyou.html"><img src="/images/menu/katsuyou_off.gif" alt="日本ワーキング・ホリデー協会活用ガイド"></a></li>
    
                <li class="lh_top"><img src="/images/menu/sep_support.gif" alt="協会のサポートを受けたい"></li>
                <li class="lh_none"><a href="/mem"><img src="/images/menu/mem_off.gif" alt="日本ワーキング・ホリデー協会のサポート内容（メンバー登録）"></a></li>
                <li class="lh_none"><a href="/seminar.html"><img src="/images/menu/seminar_off.gif" alt="無料セミナー"></a></li>
                <li class="lh_none"><a href="/kouenseminar.php"><img src="/images/menu/kouen_off.gif" alt="講演セミナー"></a></li>
                <li class="lh_none"><a href="/event.html"><img src="/images/menu/event_off.gif" alt="イベントカレンダー"></a></li>
                <li class="lh_none"><a href="/return.html"><img src="/images/menu/return_off.gif" alt="帰国後のサポート"></a></li>
                <li class="lh_none"><a href="/qa.html"><img src="/images/menu/qa_off.gif" alt="よくある質問"></a></li>
                <li class="lh_none"><a href="/trans.html"><img src="/images/menu/trans_off.gif" alt="翻訳サービス"></a></li>
                <li class="lh_block"><a href="/gogaku-spec.html"><img src="/images/menu/gogaku_off.gif" alt="語学講座"></a></li>
    
                <li class="lh_top"><img src="/images/menu/sep_info.gif" alt="お役立ち情報"></li>
                <li class="lh_none"><a href="/info.html"><img src="/images/menu/info_off.gif" alt="お役立ちリンク集"></a></li>
                <li class="lh_none"><a href="/school.html"><img src="/images/menu/school_off.gif" alt="語学学校（海外・国内）"></a></li>
                <li class="lh_none"><a href="/support.html"><img src="/images/menu/support_off.gif" alt="サポート機関"></a></li>
                <li class="lh_none"><a href="/service.html"><img src="/images/menu/service_off.gif" alt="サービス（保険・アコモデーション等）"></a></li>
                <li class="lh_sep"><a href="/company.html"><img src="/images/menu/company_off.gif" alt="会員企業一覧（企業会員について）"></a></li>
                <li class="lh_sep"><a href="/attention.html"><img src="/images/menu/attention_off.gif" alt="外国人ワーキング・ホリデー青年"></a></li>
    
                <li class="lh_sep"><a href="/jobboard.html"><img src="/images/menu/jobboard_off.gif" alt="jobboard"></a></li>
    
                <li class="lh_block"><a href="/access.html"><img src="/images/menu/access_off.gif" alt="アクセス（東京本部）"></a></li>
    
                <li class="lh_top"><img src="/images/menu/sep_com.gif" alt="協賛企業を求めています"></li>
                <li class="lh_none"><a href="/mem-com.html"><img src="/images/menu/mem_com_off.gif" alt="企業会員について（会員制度ご紹介・意義・メリット）"></a></li>
                <li class="lh_sep"><a href="/adv.html"><img src="/images/menu/adv_off.gif" alt="広告掲載のご案内"></a></li>
                <li class="lh_sep"><a href="/volunteer.html"><img src="/images/menu/volunteer_off.gif" alt="ボランティア・インターン募集"></a></li>
                <li class="lh_none"><a href="/privacy.html"><img src="/images/menu/privacy_off.gif" alt="個人情報の取り扱い"></a></li>
                <li class="lh_none"><a href="/about.html#deal"><img src="/images/menu/deal_off.gif" alt="特定商取引に関する表記"></a></li>
                <li class="lh_none"><a href="/sitemap.html"><img src="/images/menu/sitemap_off.gif" alt="サイトマップ"></a></li>
            </ul>
        </div>
        <div class="g-n-sec02">
            <ul id="g-n-main01">

                <li style="margin-top:-35px; padding-left:3px;">
                    <a  href="../seminar.html" onclick="javascript: _gaq.push(['_trackPageview' , '/banner_seminar_left/']);"><img src="/images/semi_bottombanner_off.jpg" width="220"></a><br/>
                </li>
    
                <li style="margin-top:10px; margin-left:3px; width:220px; height:80px;">
				<?php
                    // B11
                  define('MAX_PATH', '/var/www/html/ad');
                  if (@include_once(MAX_PATH . '/www/delivery/alocal.php')) 
				  {
                    if (!isset($phpAds_context)) 
					{
                      $phpAds_context = array();
                    }
                    // function view_local($what, $zoneid=0, $campaignid=0, $bannerid=0, $target='', $source='', $withtext='', $context='', $charset='')
                    $phpAds_raw = view_local('', 123, 0, 0, '', '', '0', $phpAds_context, '');
                    $phpAds_context[] = array('!=' => 'bannerid:'.$phpAds_raw['bannerid']);
                  }
                  echo $phpAds_raw['html'];
                ?>
                </li>
                <li style="margin-top:10px; margin-left:3px; width:220px; height:80px;">
				<?php
                    // B12
                  define('MAX_PATH', '/var/www/html/ad');
                  if (@include_once(MAX_PATH . '/www/delivery/alocal.php'))
				  {
                    if (!isset($phpAds_context)) 
					{
                      $phpAds_context = array();
                    }
                    // function view_local($what, $zoneid=0, $campaignid=0, $bannerid=0, $target='', $source='', $withtext='', $context='', $charset='')
                    $phpAds_raw = view_local('', 124, 0, 0, '', '', '0', $phpAds_context, '');
                    $phpAds_context[] = array('!=' => 'bannerid:'.$phpAds_raw['bannerid']);
                  }
                  echo $phpAds_raw['html'];
                ?>
                </li>
                <li style="margin-top:10px; margin-left:3px; width:220px; height:80px;">
                <?php
                    // B13
                  define('MAX_PATH', '/var/www/html/ad');
                  if (@include_once(MAX_PATH . '/www/delivery/alocal.php')) 
				  {
                    if (!isset($phpAds_context)) 
					{
                      $phpAds_context = array();
                    }
                    // function view_local($what, $zoneid=0, $campaignid=0, $bannerid=0, $target='', $source='', $withtext='', $context='', $charset='')
                    $phpAds_raw = view_local('', 125, 0, 0, '', '', '0', $phpAds_context, '');
                    $phpAds_context[] = array('!=' => 'bannerid:'.$phpAds_raw['bannerid']);
                  }
                  echo $phpAds_raw['html'];
                ?>
                </li>
    
                <li style="margin-top:20px; padding-left:10px;">
				<?php
                    // C01
                  define('MAX_PATH', '/var/www/html/ad');
                  if (@include_once(MAX_PATH . '/www/delivery/alocal.php')) 
				  {
                    if (!isset($phpAds_context)) 
					{
                      $phpAds_context = array();
                    }
                    // function view_local($what, $zoneid=0, $campaignid=0, $bannerid=0, $target='', $source='', $withtext='', $context='', $charset='')
                    $phpAds_raw = view_local('', 30, 0, 0, '', '', '0', $phpAds_context, '');
                  }
                  echo $phpAds_raw['html'];
                ?>
                </li>
    
                <li style="margin-top:10px; padding-left:3px;">
				<?php
                    // C02
                  define('MAX_PATH', '/var/www/html/ad');
                  if (@include_once(MAX_PATH . '/www/delivery/alocal.php')) 
				  {
                    if (!isset($phpAds_context)) 
					{
                      $phpAds_context = array();
                    }
                    // function view_local($what, $zoneid=0, $campaignid=0, $bannerid=0, $target='', $source='', $withtext='', $context='', $charset='')
                    $phpAds_raw = view_local('', 31, 0, 0, '', '', '0', $phpAds_context, '');
                  }
                  echo $phpAds_raw['html'];
                ?>
				</li>

            </ul>
        </div>

		<?php echo $msg;	?>

    </div><!--global-navEND-->
    
<?php
	}// end fncMenubar function


	//
	// 下部メニュー
	//
	function fncMenuFooter()	
	{
?>
        <div id="footer">
            <div id="footer-content" >
                <table>
                    <tr>
                        <td>
                            ▼ワーキング・ホリデーについて知りたい<br />
                            <a class="footer-link" href="/system.html">・ワーキングホリデー制度について</a><br />
                            <a class="footer-link" href="/start.html">・はじめてのワーキングホリデー</a><br />
                            <a class="footer-link" href="/visa/visa_top.html">・ワーキングホリデー協定国（ビザ情報）</a><br />
                            &nbsp;<br />
				▼国別ワーキングホリデーガイド<br />
				<a style="color:white;" href="/wh/australia/">・オーストラリアのワーホリ (ワーキングホリデー)</a><br />
				<a style="color:white;" href="/wh/canada/">・カナダのワーホリ (ワーキングホリデー)</a><br />
<!--
				<a style="color:white;" href="/wh/canada/">・ニュージーランドのワーホリ</a><br />
				<a style="color:white;" href="/wh/canada/">・韓国のワーホリ</a><br />
				<a style="color:white;" href="/wh/canada/">・フランスのワーホリ</a><br />
				<a style="color:white;" href="/wh/canada/">・ドイツのワーホリ</a><br />
				<a style="color:white;" href="/wh/canada/">・イギリスのワーホリ</a><br />
				<a style="color:white;" href="/wh/canada/">・アイルランドのワーホリ</a><br />
				<a style="color:white;" href="/wh/canada/">・デンマークのワーホリ</a><br />
				<a style="color:white;" href="/wh/canada/">・台湾のワーホリ</a><br />
				<a style="color:white;" href="/wh/canada/">・香港のワーホリ</a><br />
-->
                            &nbsp;<br />
                            ▼日本ワーキングホリデー協会について知りたい<br />
                            <a class="footer-link" href="/about.html">・一般社団法人日本ワーキング・ホリデー協会について</a><br />
                            <a class="footer-link" href="/katsuyou.html">・日本ワーキングホリデー協会活用ガイド</a><br />
                            &nbsp;<br />
                            <a id="footer-link-register" href="/mem/register.php">・メンバー登録をしてサポートを受ける</a><br />
                        </td>
			<td>
                            ▼ワーホリ協会が考える語学留学<br />
				<a class="footer-link" href="/ryugaku/">・語学留学</a><br />
				<a class="footer-link" href="/ryugaku/ryugaku_hiyou.html">・語学留学の費用 </a><br />
				<a class="footer-link" href="/ryugaku/usa_lang.html">・アメリカ語学留学</a><br />
				<a class="footer-link" href="/ryugaku/usa_visa.html">・アメリカ語学留学ビザ</a><br />
				<a class="footer-link" href="/ryugaku/aus_lang.html">・オーストラリア語学留学の特徴 </a><br />
				<a class="footer-link" href="/ryugaku/aus_point.html">・オーストラリア語学留学の良い点 </a><br />
				<a class="footer-link" href="/ryugaku/aus_visa.html">・オーストラリア語学留学ビザ </a><br />
				<a class="footer-link" href="/ryugaku/can_lang.html">・カナダ語学留学 </a><br />
				<a class="footer-link" href="/ryugaku/eng_lang.html">・イギリス語学留学 </a><br />
				<a class="footer-link" href="/ryugaku/eng_visa.html">・イギリス語学留学ビザ </a><br />
				<a class="footer-link" href="/ryugaku/fiji_lang.html">・フィジー語学留学・フィリピン留学 </a><br />
                            &nbsp;<br />
                            ▼ワーホリ協会が考える大学留学<br />
				<a class="footer-link" href="/ryugaku/ryugaku_eng.html">・大学留学に必要な英語力</a><br />
				<a class="footer-link" href="/ryugaku/usa_sat.html">・大学留学に必要な英語以外の試験 </a><br />
				<a class="footer-link" href="/ryugaku/usa_univ.html">・アメリカ大学留学</a><br />
				<a class="footer-link" href="/ryugaku/aus_univ.html">・オーストラリア大学留学</a><br />
				<a class="footer-link" href="/ryugaku/eng_univ.html">・イギリス大学留学 </a><br />
				<a class="footer-link" href="/ryugaku/ryugaku_jawhm.html">・留学に向けたワーホリ協会の活用 </a><br />
			</td>

                        <td>
                            ▼協会のサポートを受けたい<br />
                            <a class="footer-link" href="/mem/">・協会のサポート内容（メンバー登録）</a><br />
                            <a class="footer-link" href="/seminar.html">・無料セミナー</a><br />
                            <a class="footer-link" href="/kouenseminar.php">・講演セミナー</a><br />
                            <a class="footer-link" href="/event.html">・イベントカレンダー</a><br />
                            <a class="footer-link" href="/return.html">・帰国後のサポート</a><br />
                            <a class="footer-link" href="/qa.html">・よくある質問</a><br />
                            <a class="footer-link" href="/trans.html">・翻訳サービス</a><br />
                            <a class="footer-link" href="/gogaku-spec.html">・語学講座</a><br />
                            &nbsp;<br />
                            ▼お役立ち情報<br />
                            <a class="footer-link" href="/info.html">・お役立ちリンク集</a><br />
                            <a class="footer-link" href="/school.html">・語学学校（海外・国内）</a><br />
                            <a class="footer-link" href="/support.html">・サポート機関（海外・国内）</a><br />
                            <a class="footer-link" href="/service.html">・サービス（保険・アコモデーション等）</a><br />
                            <a class="footer-link" href="/company.html">・会員企業一覧（企業会員について）</a><br />
                        </td>
                        <td>
                            ▼協賛企業を求めています<br />
                            <a class="footer-link" href="/mem-com.html">・企業会員について（会員制度ご紹介・意義・メリット）</a><br />
                            <a class="footer-link" href="/adv.html">・広告掲載のご案内</a><br />
                            &nbsp;<br />
                            ▼ワーホリ協会のいろいろ<br />
                            <a class="footer-link" href="/volunteer.html">・ボランティア・インターン募集</a><br />
                            <a class="footer-link" href="/privacy.html">・個人情報の取り扱い</a><br />
                            <a class="footer-link" href="/about.html#deal">・特定商取引に関する表記</a><br />
                            <a class="footer-link" href="/sitemap.html">・サイトマップ</a><br />
                            &nbsp;<br />
                            ▼海外からのワーキングホリデー<br />
                            <a class="footer-link" href="/attention.html">・外国人ワーキング・ホリデー青年</a><br />
                            &nbsp;<br />
                            ▼アクセス<br />
                            <a class="footer-link" href="/access.html#tokyo-office">・東京オフィス</a>&nbsp;&nbsp;-&nbsp;<a class="footer-link" href="/event/map/?p=tokyo" target="_blank">Map</a><br />
                            <a class="footer-link" href="/access.html#osaka-office">・大阪オフィス</a>&nbsp;&nbsp;-&nbsp;<a class="footer-link" href="/event/map/?p=osaka" target="_blank">Map</a><br />
                            <a class="footer-link" href="/office/fukuoka/map.php" target="_blank">・福岡カフェバーマンリー</a>&nbsp;&nbsp;-&nbsp;<a class="footer-link" href="/event/map/?p=fukuoka" target="_blank">Map</a><br />
                            <a class="footer-link" href="/event/map/?p=okinawa" target="_blank">・沖縄e-sa(イーサ）</a><br />
                        </td>
                    </tr>
                </table>
            </div>
            <div id="footer-box">
                <img src="/images/foot-co.gif" alt="" />
            </div>
        </div>
        
        <!-- 次のタグを head 要素内または body 終了タグの直前に貼り付けてください -->
        <script type="text/javascript" src="https://apis.google.com/js/plusone.js">
          {lang: 'ja'}
        </script>

<?php
	} //end fncMenuFooter function 


	//
	// 下部メニュー（リンクなし）
	//
	function fncMenuFooterNolink()	
	{
?>
        <div id="footer">
            <div id="footer-box">
                <img src="/images/foot-co.gif" alt="" />
            </div>
        </div>

        <!-- 次のタグを head 要素内または body 終了タグの直前に貼り付けてください -->
        <script type="text/javascript" src="https://apis.google.com/js/plusone.js">
          {lang: 'ja'}
        </script>

<?php
	}
?>
