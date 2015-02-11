<?php

//	ini_set( "display_errors", "On");


//
// Facebook用メタ
//
    function fncFacebookMeta()
    {
?>
    <meta property="og:title" content="ワーキングホリデー（ワーホリ）・留学の事なら日本ワーキングホリデー協会" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="http://www.jawhm.or.jp<?php print $_SERVER["REQUEST_URI"]; ?>" />
    <meta property="og:image" content="http://www.jawhm.or.jp/images/fb-image.jpg" />
    <meta property="og:site_name" content="日本ワーキング・ホリデー協会" />
    <meta property="og:locale" content="ja_JP" />
    <meta property="og:description" content="ワーキングホリデー・留学の事なら日本ワーキングホリデー協会。無料セミナー、毎日開催中！！" />
    <link rel="shortcut icon" href="http://www.jawhm.or.jp/images/favicon.ico" type="image/x-icon" />
<?php
    }//end fncFacebookMeta function

//
// ヘッダー定義
//
    function fncMenuHead($imghtml, $h1_text='', $link='')
    {
        //display header without links
        if($link == 'nolink')
        {
            ?>
<script type="text/javascript" src="/js/taglogscript.js"></script>
<script type="text/javascript">
$script("https://www.taglog.jp/taglog.js", "taglog");
$script.ready("taglog",
    function() {
        taglog.init("https://www.jawhm.or.jp/");
        $script("https://www.taglog.jp/taglog-clickmap.js", "taglog-clickmap");
        $script("https://www.taglog.jp/taglog-pageanalysis.js", "taglog-pageanalysis");
     }
 );
</script>
            <div id="header">
                <div id="header_left">
                    <h1 id="logotext"><?php echo $h1_text; ?></h1>
                    <div id="topimg">
                        <a href="/" title="一般社団法人日本ワーキング・ホリデー協会">
                            <img src="/images/h1-logo.jpg" alt="日本ワーキングホリデー協会" />
                        </a>
                    </div>
                </div>
            <div style="height:50px;"></div>
                <?php echo $imghtml; ?>
            </div>
<?php
        }
        else
        {
            ?>
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
            <div id="contactable"><!-- contactable html placeholder --></div>
            <script type="text/javascript" src="/js/feedback/jquery.validate.pack.js"></script>
            <script type="text/javascript" src="/js/feedback/jquery.contactable.js"></script>
            <script type="text/javascript">
                $(function(){$('#contactable').contactable({subject: 'feedback URL:'+location.href});});
            </script>
<script type="text/javascript" src="/js/taglogscript.js"></script>
<script type="text/javascript">
$script("https://www.taglog.jp/taglog.js", "taglog");
$script.ready("taglog",
    function() {
        taglog.init("https://www.jawhm.or.jp/");
        $script("https://www.taglog.jp/taglog-clickmap.js", "taglog-clickmap");
        $script("https://www.taglog.jp/taglog-pageanalysis.js", "taglog-pageanalysis");
     }
 );
</script>
            <div id="header">
                <div id="header_left">
                    <h1  id="logotext"><?php echo $h1_text; ?></h1>
                    <div id="topimg">
                        <a href="/" title="一般社団法人日本ワーキング・ホリデー協会">
                            <img src="/images/h1-logo.jpg" alt="日本ワーキングホリデー協会" />
                        </a>
                    </div>
                </div>
                <h2><a href="/member"><img src="/images/menu/member_off.gif" alt="日本ワーキングホリデー協会のサービスを利用する" /></a></h2>
                <div id="utility-nav">
                    <ul>
                      <li class="u-nav01"><a href="/">日本語</a></li>
                      <li class="u-nav02"><a href="/eng/">英語</a></li>
                      <!--<li class="u-nav03"><a href="/blog/">ブログ</a></li>-->
                    </ul>
                </div>
                <?php echo $imghtml; ?>
                <div id="social_tool" style="position:absolute; top:100px; left:620px;">
                    <table><tr>
                    <td style="vertical-align:top;">
                        <div class="fb-like" data-send="false" data-layout="button_count" data-width="110" data-show-faces="false" data-font="arial"></div>
                    </td>
                    <td style="vertical-align:top;">
                        <a href="https://twitter.com/share" class="twitter-share-button" data-count="horizontal" data-via="jawhm">Tweet</a>
                        <script type="text/javascript" src="//platform.twitter.com/widgets.js"></script>
                    </td>
                    <td style="vertical-align:top;">
                        <!--<g:plusone></g:plusone>-->
                        <div class="g-plusone"></div>
                        <script type="text/javascript">
                          window.___gcfg = {lang: 'ja'};

                          (function() {
                            var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
                            po.src = 'https://apis.google.com/js/plusone.js';
                            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
                          })();
                        </script>
                    </td>
                    </tr></table>
                </div>

            <?php
                $html_global_menu = '';
                    if ($_SERVER["REQUEST_URI"] == '/seminar/seminar') {
                    $html_global_menu .= '<div id="global-menu" class="global-menu-seminar">';
                    $html_global_menu .= '<ul id="global-menu-list" class="clearfix">';
                    $html_global_menu .= '<li id="global-menu-list-01"><a href="/system.html">ワーキングホリデー制度について</a></li>';
                    $html_global_menu .= '<li id="global-menu-list-02"><a href="/start.html">はじめてのワーホリ</a></li>';
                    $html_global_menu .= '<li id="global-menu-list-03"><a href="/seminar/seminar">無料セミナー</a></li>';
                    $html_global_menu .= '<li id="global-menu-list-04"><a href="/qa.html">よくある質問</a></li>';
                    $html_global_menu .= '<li id="global-menu-list-05"><a href="/blog/">ワーホリブログ</a></li>';
                    $html_global_menu .= '<li id="global-menu-list-06"><a href="/about.html">協会について</a></li>';
                    $html_global_menu .= '<li id="global-menu-list-07"><a href="/country/">ワーホリ協定国</a></li>';
                    $html_global_menu .= '<li id="global-menu-list-08"><a href="/office/">アクセス</a></li>';
                    $html_global_menu .= '</ul>';
                    $html_global_menu .= '</div>';
                } else {
                    $html_global_menu .= '<div id="global-menu">';
                    $html_global_menu .= '<ul id="global-menu-list" class="clearfix">';
                    $html_global_menu .= '<li id="global-menu-list-01"><a href="/system.html">ワーキングホリデー制度について</a></li>';
                    $html_global_menu .= '<li id="global-menu-list-02"><a href="/start.html">はじめてのワーホリ</a></li>';
                    $html_global_menu .= '<li id="global-menu-list-03"><a href="/seminar/seminar">無料セミナー</a></li>';
                    $html_global_menu .= '<li id="global-menu-list-04"><a href="/qa.html">よくある質問</a></li>';
                    $html_global_menu .= '<li id="global-menu-list-05"><a href="/blog/">ワーホリブログ</a></li>';
                    $html_global_menu .= '<li id="global-menu-list-06"><a href="/about.html">協会について</a></li>';
                    $html_global_menu .= '<li id="global-menu-list-07"><a href="/country/">ワーホリ協定国</a></li>';
                    $html_global_menu .= '<li id="global-menu-list-08"><a href="/office/">アクセス</a></li>';
                    $html_global_menu .= '</ul>';
                    $html_global_menu .= '</div>';
                }
                    echo($html_global_menu);
            ?>

           </div>

<?php
        }
    }//end fncMenuHead function



    //
    // 左サイドメニュー
    // Function to display the navigation bar on the left hand side
    //
    function fncMenubar($msg='', $advertisement='')
    {
        $device_obj = new Header();

        global $header_obj;

?>
        <div id="global-nav" style="position:relative;">
        <div class="g-n-sec02" style="padding-bottom:0px;">
        <?php
        if($_SESSION['pc'] != 'on' && $device_obj->computer_use() === false)
    { ?>
            <table style="width:100%;">
                <tr>
                    <td><div id="btn-register"><a href="/mem2/register.php" title="メンバー登録はこちら">メンバー登録はこちら</a></div></td>
                    <?php if($_SESSION['mem_id'] != '' && $_SESSION['mem_name'] != '' && $_SESSION['mem_level'] != -1)
                                $button_name = 'メンバーページ';
                           else
                                $button_name = 'メンバーログイン';
                    ?>
                    <td style="width:135px;"><div id="btn-member"><a href="/member/" title="<?php echo $button_name;?>"><?php echo $button_name;?></a></div></td>
                </tr>
            </table>
        <?php
            }
            elseif($_SESSION['pc'] == 'on' && $device_obj->computer_use() === false)
            { ?>
            <form name="change_view" method="POST" action="">
                <input type="hidden" name="pc" value="off" />
                <div id="btn-for-smartphone"><input type="submit" value="Smartphone version" /></div>
               </form>
        <?php
            } ?>

        <?php
        //************************************//
        //*------MOBILE HOME PAGE ONLY-------*//
        //************************************//

        if($device_obj->computer_use() === false && $_SESSION['pc'] != 'on' && $header_obj->pcmobile_type === false)
        {
        ?>

           <div style="margin:0 auto 10px auto; height:94px; text-align:center;">
<!--                <a href='http://www.jawhm.or.jp/ad/www/delivery/ck.php?oaparams=2__bannerid=226__zoneid=22__cb=b3fa7843b7__oadest=http%3A%2F%2Fwww.jawhm.or.jp%2F2012autumnfair%2F' target='_top'><img src='http://www.jawhm.or.jp/ad/www/images/0e92b258fd751242d83521241ec575f3.gif' width='430' height='94' alt='秋の留学＆ワーキングホリデーフェア2012' title='秋の留学＆ワーキングホリデーフェア2012'  /></a>
                <div id='beacon_b3fa7843b7' style='position: absolute; left: 0px; top: 0px; visibility: hidden;'><img src='http://www.jawhm.or.jp/ad/www/delivery/lg.php?bannerid=226&amp;campaignid=86&amp;zoneid=22&amp;loc=http%3A%2F%2Fwww.jawhm.or.jp%2F&amp;cb=b3fa7843b7' width='0' height='0' alt='' style='width: 0px; height: 0px;' /></div>
-->                <?php
                    // W01
                  define('MAX_PATH', '/var/www/html/ad');
                  if (@include_once(MAX_PATH . '/www/delivery/alocal.php')) {
                    if (!isset($phpAds_context)) {
                      $phpAds_context = array();
                    }
                    // function view_local($what, $zoneid=0, $campaignid=0, $bannerid=0, $target='', $source='', $withtext='', $context='', $charset='')
                    $phpAds_raw = view_local('', 22, 0, 0, '', '', '0', $phpAds_context, '');
                    $phpAds_context[] = array('!=' => 'bannerid:'.$phpAds_raw['bannerid']);
                  }
                  echo $phpAds_raw['html'];
                ?>

            </div>

           <div style="margin:0 auto -5px auto; height:94px; text-align:center;">

        <a href="/seminar">
        <img alt="" src="/images/menu/seminar_top_off.png">
        </a>

    </div>

            <div class="g-n-sec02">
                <div class="lh_top"><span class="lh_top_left">Pick Up</span></div>
                <div id="feed">
<?php

    ini_set( "display_errors", "On");
    mb_language("Ja");
    mb_internal_encoding("utf8");

        try {
            $ini = parse_ini_file('../bin/pdo_wporjp.ini', FALSE);
            $tmpdb = new PDO($ini['dsn'], $ini['user'], $ini['password']);
            $tmpdb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $tmpdb->query('SET CHARACTER SET utf8');
            $tmpstt = $tmpdb->prepare("SELECT id, post_title, post_content FROM wp_posts, wp_term_relationships where wp_posts.id = wp_term_relationships.object_id and wp_term_relationships.term_taxonomy_id = 5 and post_status = 'publish' order by post_date desc limit 0,3");
            $tmpstt->execute();
            $idx = 0;
            $cur_id = '';
            while($row = $tmpstt->fetch(PDO::FETCH_ASSOC)){
                $idx++;
                $cur_id = $row['id'];
                $cur_title = $row['post_title'];
                $cur_content = $row['post_content'];

                if ($idx == 1)	{
                    echo '<div class="top-pickup" style="margin-top:0px;">';
                }else{
                    echo '<div class="top-pickup">';
                }
                echo '<p><img src="images/arrow030'.rand(2,10).'.gif" alt="PickUp">　<a href="/ja/'.$cur_id.'">'.strip_tags($cur_title).'</a></p>';
                echo '<p>'.mb_substr(preg_replace('/(\s|　)/','',strip_tags($cur_content)),0,100).'... [<a href="/ja/'.$cur_id.'">続き</a>]</p>';
                echo '</div>';
            }
            $tmpdb = NULL;
        } catch (PDOException $e) {
            echo ($e->getMessage());
        }

?>
                </div>
            </div>

        <?php
        }
        //************************************//
        //*----END MOBILE HOME PAGE ONLY-----*//
        //************************************//

        //=====================================//
        //----------PC HOME PAGE ONLY----------//
        //=====================================//

         if($device_obj->computer_use() || $_SESSION['pc'] == 'on')
        {
            ?>
            <ul class="g-n-main01">
                <li class="lh_top0">
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

                    //first value of the advertisement array is used here!
                    $phpAds_raw = view_local('',  $advertisement[0], 0, 0, '', '', '0', $phpAds_context, '');
                    $phpAds_context[] = array('!=' => 'bannerid:'.$phpAds_raw['bannerid']);
                  }
                  echo $phpAds_raw['html'];
                ?>
                </li>
            </ul>

        <?php
        }
        //=====================================//
        //--------END PC HOME PAGE ONLY--------//
        //=====================================//
                                                ?>


        </div>
        <a name="page"><div class="g-n-sec02" style="padding-top:0px; padding-bottom:0px;margin-bottom:5px;"></a>
            <?php include(PATH.'calendar_module/mod_event_vertical.php');?>
        </div>

        <div class="g-n-sec02">
            <ul class="g-n-main01">
                <li class="lh_top"><span class="lh_top_left">ワーキング・ホリデーについて知りたい</span></li>
                <li class="lh_none"><a href="/system.html" title="ワーキング・ホリデー制度について">ワーキング・ホリデー制度について</a></li>
                <li class="lh_none"><a href="/start.html" title="はじめてのワーキング・ホリデー">はじめてのワーキング・ホリデー</a></li>
                <li class="lh_bottom"><a href="/country" title="ワーキング・ホリデー協定国（ビザ情報）">ワーキング・ホリデー協定国（ビザ情報）</a></li>

                <?php
                //************************************//
                //*------MOBILE HOME PAGE ONLY-------*//
                //************************************//

                if($device_obj->computer_use() === false && $_SESSION['pc'] != 'on' && $header_obj->pcmobile_type === false)
                {
                    ?>
                    <table style="margin:10px auto 5px auto;">
                        <tr>
                            <td>
                                <?php
                                    // S01
                                  define('MAX_PATH', '/var/www/html/ad');
                                  if (@include_once(MAX_PATH . '/www/delivery/alocal.php')) {
                                    if (!isset($phpAds_context)) {
                                      $phpAds_context = array();
                                    }
                                    // function view_local($what, $zoneid=0, $campaignid=0, $bannerid=0, $target='', $source='', $withtext='', $context='', $charset='')
                                    $phpAds_raw = view_local('', 24, 0, 0, '', '', '0', $phpAds_context, '');
                                    $phpAds_context[] = array('!=' => 'bannerid:'.$phpAds_raw['bannerid']);
                                  }
                                  echo $phpAds_raw['html'];
                                ?>
<!--                                <a href='http://www.jawhm.or.jp/ad/www/delivery/ck.php?oaparams=2__bannerid=214__zoneid=24__cb=c920e39b40__oadest=http%3A%2F%2Fwww.jawhm.or.jp%2Fkouenseminar.php' target='_top'><img src='http://www.jawhm.or.jp/ad/www/images/da24d70b4136ab0970c7516230bf218c.gif' width='210' height='55' alt='新企画　講演セミナー' title='新企画　講演セミナー'  /></a><div id='beacon_c920e39b40' style='position: absolute; left: 0px; top: 0px; visibility: hidden;'><img src='http://www.jawhm.or.jp/ad/www/delivery/lg.php?bannerid=214&amp;campaignid=74&amp;zoneid=24&amp;loc=http%3A%2F%2Fwww.jawhm.or.jp%2F&amp;cb=c920e39b40' width='0' height='0' alt='' style='width: 0px; height: 0px;' /></div>
-->                            </td>
                            <td>
                                <?php
                                    // S02
                                  define('MAX_PATH', '/var/www/html/ad');
                                  if (@include_once(MAX_PATH . '/www/delivery/alocal.php')) {
                                    if (!isset($phpAds_context)) {
                                      $phpAds_context = array();
                                    }
                                    // function view_local($what, $zoneid=0, $campaignid=0, $bannerid=0, $target='', $source='', $withtext='', $context='', $charset='')
                                    $phpAds_raw = view_local('', 26, 0, 0, '', '', '0', $phpAds_context, '');
                                    $phpAds_context[] = array('!=' => 'bannerid:'.$phpAds_raw['bannerid']);
                                  }
                                  echo $phpAds_raw['html'];
                                ?>
<!--                                <a href='http://www.jawhm.or.jp/ad/www/delivery/ck.php?oaparams=2__bannerid=258__zoneid=26__cb=3b3757fc71__oadest=http%3A%2F%2Fwww.jawhm.or.jp%2Fseminar%2Fseminar.php%3Fnavigation%3D1%26month%3D10%26year%3D2012%26day%3D24%26place_name%3Dtokyo%26checked_countryname%3D1%26checked_know%3D0%23calendar_start' target='_top'><img src='http://www.jawhm.or.jp/ad/www/images/d983c9c83da1fcffa4e70614b37691dc.gif' width='210' height='55' alt='オーストラリア＆カナダセミナー' title='オーストラリア＆カナダセミナー'  /></a><div id='beacon_3b3757fc71' style='position: absolute; left: 0px; top: 0px; visibility: hidden;'><img src='http://www.jawhm.or.jp/ad/www/delivery/lg.php?bannerid=258&amp;campaignid=106&amp;zoneid=26&amp;loc=http%3A%2F%2Fwww.jawhm.or.jp%2F&amp;cb=3b3757fc71' width='0' height='0' alt='' style='width: 0px; height: 0px;' /></div>
-->                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php
                                    // S03
                                  define('MAX_PATH', '/var/www/html/ad');
                                  if (@include_once(MAX_PATH . '/www/delivery/alocal.php')) {
                                    if (!isset($phpAds_context)) {
                                      $phpAds_context = array();
                                    }
                                    // function view_local($what, $zoneid=0, $campaignid=0, $bannerid=0, $target='', $source='', $withtext='', $context='', $charset='')
                                    $phpAds_raw = view_local('', 27, 0, 0, '', '', '0', $phpAds_context, '');
                                    $phpAds_context[] = array('!=' => 'bannerid:'.$phpAds_raw['bannerid']);
                                  }
                                  echo $phpAds_raw['html'];
                                ?>
<!--                                <a href='http://www.jawhm.or.jp/ad/www/delivery/ck.php?oaparams=2__bannerid=238__zoneid=27__cb=7c45c3f242__oadest=http%3A%2F%2Fwww.jawhm.or.jp%2Fevent.html%2320121103' target='_top'><img src='http://www.jawhm.or.jp/ad/www/images/42f114bd563d538b2da3713ba353ad69.gif' width='210' height='55' alt='秋の名古屋セミナー' title='秋の名古屋セミナー'  /></a><div id='beacon_7c45c3f242' style='position: absolute; left: 0px; top: 0px; visibility: hidden;'><img src='http://www.jawhm.or.jp/ad/www/delivery/lg.php?bannerid=238&amp;campaignid=96&amp;zoneid=27&amp;loc=http%3A%2F%2Fwww.jawhm.or.jp%2F&amp;cb=7c45c3f242' width='0' height='0' alt='' style='width: 0px; height: 0px;' /></div>
-->                            </td>
                            <td>
                                <?php
                                    // S04
                                  define('MAX_PATH', '/var/www/html/ad');
                                  if (@include_once(MAX_PATH . '/www/delivery/alocal.php')) {
                                    if (!isset($phpAds_context)) {
                                      $phpAds_context = array();
                                    }
                                    // function view_local($what, $zoneid=0, $campaignid=0, $bannerid=0, $target='', $source='', $withtext='', $context='', $charset='')
                                    $phpAds_raw = view_local('', 28, 0, 0, '', '', '0', $phpAds_context, '');
                                    $phpAds_context[] = array('!=' => 'bannerid:'.$phpAds_raw['bannerid']);
                                  }
                                  echo $phpAds_raw['html'];
                                ?>
<!--                                <a href='http://www.jawhm.or.jp/ad/www/delivery/ck.php?oaparams=2__bannerid=257__zoneid=28__cb=a6e927a66a__oadest=http%3A%2F%2Fwww.jawhm.or.jp%2Fseminar%2Fseminar.php%3Fnavigation%3D1%26month%3D10%26year%3D2012%26day%3D23%26place_name%3Dtokyo%26checked_countryname%3D1%26checked_know%3D0%23calendar_start' target='_top'><img src='http://www.jawhm.or.jp/ad/www/images/b6f889297430b7a8fb5f2465b74dd4b4.gif' width='210' height='55' alt='留学ワーホリ交流会～ハロウィンパーティー～' title='留学ワーホリ交流会～ハロウィンパーティー～'  /></a><div id='beacon_a6e927a66a' style='position: absolute; left: 0px; top: 0px; visibility: hidden;'><img src='http://www.jawhm.or.jp/ad/www/delivery/lg.php?bannerid=257&amp;campaignid=105&amp;zoneid=28&amp;loc=http%3A%2F%2Fwww.jawhm.or.jp%2F&amp;cb=a6e927a66a' width='0' height='0' alt='' style='width: 0px; height: 0px;' /></div>
-->                            </td>
                        </tr>
                    </table>
                <?php
                }
                //************************************//
                //*----END MOBILE HOME PAGE ONLY-----*//
                //************************************//
                                                        ?>

                <li class="lh_top"><span class="lh_top_left">協会について知りたい</span></li>
                <li class="lh_none" id="pink-menu"><span id="border-pink"><a class="two-lines" href="/katsuyou.html" title="日本ワーキング・ホリデー協会活用ガイド">日本ワーキング・ホリデー協会<br/><span>活用ガイド</span></a></span></li>
                <li class="lh_none"><a class="two-lines" href="/about.html" title="一般社団法人 日本ワーキング・ホリデー協会について">一般社団法人<br />日本ワーキング・ホリデー協会について</a></li>
                <li class="lh_bottom"><a href="/ja/category/%E3%83%A1%E3%83%87%E3%82%A3%E3%82%A2%E6%8E%B2%E8%BC%89" title="メディア掲載">メディア掲載</a></li>

                <li class="lh_top"><span class="lh_top_left">協会のサポートを受けたい</span></li>
                <li class="lh_none" id="orange-menu"><span id="border-orange"><a class="two-lines" href="/mem" title="成功のためのフルサポート≪協会サポートのご案内≫">成功のためのフルサポート<br /><span>≪協会サポートのご案内≫</span></a></span></li>
                <li class="lh_none" id="check1"><a href="/seminar/seminar" title="無料セミナー">無料セミナー</a></li>
                <li class="lh_none" id="check2"><a href="/kouenseminar.php" title="講演セミナー">講演セミナー</a></li>
                <li class="lh_none"><a href="/event.html" title="イベントカレンダー">イベントカレンダー</a></li>
                <li class="lh_none"><a href="/return.html" title="帰国後のサポート">帰国後のサポート</a></li>
                <li class="lh_none"><a href="/qa.html" title="よくある質問">よくある質問</a></li>
                <!-- <li class="lh_none"><a href="/trans.html" title="翻訳サービス">翻訳サービス</a></li>-->
                <li class="lh_none"><a href="/gogaku-spec.html" title="語学講座">語学講座</a></li>
                <li class="lh_bottom"><a href="/profile.html" title="講師派遣">講師派遣</a></li>

                <li class="lh_top"><span class="lh_top_left">お役立ち情報</span></li>
                <li class="lh_none"><a href="/info.html" title="お役立ちリンク集">お役立ちリンク集</a></li>
                <li class="lh_none"><a href="/school.html" title="語学学校（海外・国内）">語学学校（海外・国内）</a></li>
    <!--
                <li class="lh_none"><a href="/support.html" title="サポート機関（海外・国内）">サポート機関（海外・国内）</a></li>
    -->
                <li class="lh_bottom"><a href="/service.html" title="サービス（保険・アコモデーション等）">サービス（保険・アコモデーション等）</a></li>
    <!--
                <li class="lh_bottom"><a href="/company.html" title="会員企業一覧（企業会員について）">会員企業一覧（企業会員について）</a></li>
    -->
        <li class="lh_alone"><a href="/blog/" title="ワーキング・ホリデー協会公式ブログ">ワーキング・ホリデー協会公式ブログ</a></li>
                <li class="lh_alone"><a href="/attention.html" title="外国人ワーキング・ホリデー青年">外国人ワーキング・ホリデー青年</a></li>
                <li class="lh_alonetop"><a href="http://japanworkingholiday.org/jobboard/" target="_blank" title="Job Board （求人掲示板）">Job Board （求人掲示板）</a></li>
                <li class="lh_bottom"><a href="/jobboard.html" title="求人情報の掲載について">求人情報の掲載について</a></li>
                <li class="lh_alone"><a href="/office/" title="アクセス（東京/大阪/名古屋/福岡）">アクセス（東京/大阪/名古屋/福岡）</a></li>

                <li class="lh_top"><span class="lh_top_left">協賛企業を求めています</span></li>
                <li class="lh_none"><a class="two-lines" href="/mem-com.html" title="企業会員について（会員制度ご紹介・意義・メリット）">企業会員について<br />（会員制度ご紹介・意義・メリット）</a></li>
                <li class="lh_bottom"><a href="/adv.html" title="広告掲載のご案内">広告掲載のご案内</a></li>
                <li class="lh_alone"><a href="/volunteer.html" title="ボランティア・インターン募集">ボランティア・インターン募集</a></li>
                <li class="lh_top_small"><a href="/privacy.html" title="個人情報の取扱">個人情報の取扱</a></li>
                <li class="lh_none_small"><a href="/about.html#deal" title="特定商取引に関する表記">特定商取引に関する表記</a></li>
                <li class="lh_bottom_small"><a href="/sitemap.html" title="サイトマップ">サイトマップ</a></li>
            </ul>
        </div>

                <div style="margin:0px 0px 0 12px;">
                <p><a href="http://srs.jawhm.or.jp"><img src="/images/sidebanner01.gif" alt="PickUp" /></a></p>
                </div>
                <div style="margin:0px 0px 0 12px;">
                <p><a href="http://sabusan.jp"><img src="/images/sabusanjp_side.gif" alt="PickUp" /></a></p>
                </div>

        <div class="g-n-sec02">

        <?php
        //************************************//
        //*------MOBILE HOME PAGE ONLY-------*//
        //************************************//

        if($device_obj->computer_use() === false && $_SESSION['pc'] != 'on' && $header_obj->pcmobile_type === false)
        {
            ?>
            <div style="margin:10px auto 10px auto; text-align:center; font-size:8pt;">
                <a href="/seminar/seminar"><img src="/images/menu/seminar_top_off.png" alt="" /></a><br />
<!--                <a href='http://www.jawhm.or.jp/ad/www/delivery/ck.php?oaparams=2__bannerid=137__zoneid=29__cb=41d27975ed__oadest=http%3A%2F%2Fwww.jpcashpassport.jp%2Fcpp%2Ftoratora.html' target='_blank'><img src='http://www.jawhm.or.jp/ad/www/images/ffbd49aeff3845e79929c971d92d41e8.jpg' width='214' height='121' alt='キャッシュパスポートを作っておこう！' title='キャッシュパスポートを作っておこう！'  /></a><div id='beacon_41d27975ed' style='position: absolute; left: 0px; top: 0px; visibility: hidden;'><img src='http://www.jawhm.or.jp/ad/www/delivery/lg.php?bannerid=137&amp;campaignid=17&amp;zoneid=29&amp;loc=http%3A%2F%2Fwww.jawhm.or.jp%2F&amp;cb=41d27975ed' width='0' height='0' alt='' style='width: 0px; height: 0px;' /></div>
-->                <?php
                // A01
                  define('MAX_PATH', '/var/www/html/ad');
                  if (@include_once(MAX_PATH . '/www/delivery/alocal.php')) {
                    if (!isset($phpAds_context)) {
                      $phpAds_context = array();
                    }
                    // function view_local($what, $zoneid=0, $campaignid=0, $bannerid=0, $target='', $source='', $withtext='', $context='', $charset='')
                    $phpAds_raw = view_local('', 29, 0, 0, '', '', '0', $phpAds_context, '');
                  }
                  echo $phpAds_raw['html'];
                ?>
                <br />
                <a href="http://www.aiu.co.jp/travel/trial/index.html?p=oA41F201" target="_blank"><img src="/images/aiu00.gif" title="AIU" alt="AIU" /></a><br />
                AIU保険会社のサイトへジャンプします
            </div>
        <?php
        }
        //************************************//
        //*----END MOBILE HOME PAGE ONLY-----*//
        //************************************//

        //=====================================//
        //----------PC HOME PAGE ONLY----------//
        //=====================================//

         if($device_obj->computer_use() || $_SESSION['pc'] == 'on')
        {
            //display others advertisements if more exist (the first one has been displayed before the menu)
            if(count($advertisement)>1)
            {
                echo ' <ul class="g-n-main01">';

                //start by 1 because the first value '0' is displayed before the menu
                for($i=1;$i<count($advertisement);$i++)
                {
                    echo '<li class="advertisement-vertical">';

                    define('MAX_PATH', '/var/www/html/ad');
                    if(@include_once(MAX_PATH . '/www/delivery/alocal.php'))
                    {
                        if (!isset($phpAds_context))
                        {
                          $phpAds_context = array();
                        }
                        // function view_local($what, $zoneid=0, $campaignid=0, $bannerid=0, $target='', $source='', $withtext='', $context='', $charset='')
                        $phpAds_raw = view_local('', $advertisement[$i], 0, 0, '', '', '0', $phpAds_context, '');
                        $phpAds_context[] = array('!=' => 'bannerid:'.$phpAds_raw['bannerid']);
                    }
                    echo $phpAds_raw['html'];

                    echo '</li>';
                }

                echo '</ul>';
            }
        }
        //=====================================//
        //--------END PC HOME PAGE ONLY--------//
        //=====================================//
        ?>
        </div>

        <?php
        //=====================================//
        //----------PC HOME PAGE ONLY----------//
        //=====================================//

         if($device_obj->computer_use() || $_SESSION['pc'] == 'on')
        {
            echo $msg;
        }
        //=====================================//
        //--------END PC HOME PAGE ONLY--------//
        //=====================================//
        ?>

    </div><!--global-navEND-->

<?php
    }// end fncMenubar function


    //
    // 下部メニュー
    //
    function fncMenuFooter($link='')
    {
        //display footer without links
        if($link == 'nolink')
        {
            ?>

        <div id="footer">
            <div id="footer-box">
                <div id="copyright">Copyright© JAPAN Association for Working Holiday Makers All right reserved.</div>
            </div>
        </div>
<?php
        }
        elseif($link == 'nolinkmobile')
        {
            ?>
            </div>
            <div id="footer">
                <div id="footer-box">
                    <div id="copyright">Copyright© JAPAN Association for Working Holiday Makers All right reserved.</div>
                </div>
            </div>
            <script type="text/javascript">
                myScroll.destroy();
                myScroll = null;
            </script>
<?php
        }
        elseif($link == 'mobile')
        {
            ?>
           </div>

<?php
            include(PATH.'include/footer_mobile.php');
        }
        else
        {
            include(PATH.'include/footer_pc.php');
    ?>

<script type="text/javascript">
$script.ready("taglog-clickmap",
     function() {
      taglog.clickMonitor.start(document.getElementById("header_left"));
     }
 );
$script.ready("taglog-pageanalysis",
     function() {
      taglog.pageAnalyzer.start();
     }
 );
</script>
<?php
        }
    } //end fncMenuFooter function
