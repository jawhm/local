<?php
require_once('include/mobile_function.php');

require_once ('include/where_condition_new.php');

require_once ('../seminar_module/seminar_db.php');


ini_set('session.bug_compat_42', 0);

ini_set('session.bug_compat_warn', 0);



session_start();

$use_area = true;



list(, $para1, $para2, $para3, $para4, $para5, $para6) = explode('/', $_SERVER['PATH_INFO']);

$c_base = $_SERVER['REQUEST_URI'];



// The MAX_PATH below should point to the base of your OpenX installation

$big_size = array("width='585'", "height='295'", "width='584'", "height='145'");

$sml_size = array("width='380'", "height='192'", "width='380'", "height='74'");

define('MAX_PATH', '/var/www/html/ad');

$big_banner = array();

$sml_banner = array();

if (@include_once(MAX_PATH . '/www/delivery/alocal.php')) {

    if (!isset($phpAds_context)) {

        $phpAds_context = array();
    }



//	  $ids = array(155, 151, 159, 160, 161);
//	  foreach ($ids as $id) {
//		  //$phpAds_context = array();
//		  $phpAds_raw = view_local('', $id, 0, 0, '_blank', '', '0', $phpAds_context, '');
//		  $phpAds_context[] = array('!=' => 'campaignid:'.$phpAds_raw['campaignid']);
//		  $phpAds_context[] = array('!=' => 'bannerid:'.$phpAds_raw['bannerid']);
//		  if (empty($phpAds_raw['html'])) continue;
//		  $big_banner[] = str_replace($big_size, $sml_size, $phpAds_raw['html']);
//	  }
//	0 : 180 ALL
//	1 : 181 TOKYO
//	2 : 182 OSAKA
//	3 : 183 NAGOYA
//	4 : 184 FUKUOKA
//	5 : 185 OKINAWA
//	6 : 186 EVENT
//	  $ids = array(180,180);

    $ids = array(180, 181, 182, 183, 184, 185, 186);

    foreach ($ids as $id) {

        $phpAds_context = array();

        $phpAds_raw = view_local('', $id, 0, 0, '_blank', '', '0', $phpAds_context, '');

        $phpAds_context[] = array('!=' => 'campaignid:' . $phpAds_raw['campaignid']);

        $sml_banner[] = str_replace($big_size, $sml_size, $phpAds_raw['html']);
    }
}

$ser_banner = array();

$ser_banner['all'] = $sml_banner[0];

$ser_banner['tokyo'] = $sml_banner[1];

$ser_banner['osaka'] = $sml_banner[2];

$ser_banner['nagoya'] = $sml_banner[3];

$ser_banner['fukuoka'] = $sml_banner[4];

$ser_banner['okinawa'] = $sml_banner[5];

$ser_banner['event'] = $sml_banner[6];



/* ↓↓↓ 20141016追加 ↓↓↓ */

$c_footer = '



			<div class="area-btn-seminar">

				<a href="/seminar/ser-form.php" id="btn-seminar-inquiry-1" data-ajax="false">

					セミナーに関するお問い合わせはこちら <span class="icon-envelope2"></span>

				</a>



				<a href="https://jp.surveymonkey.com/s/QNGSHFR" target="_blank" id="btn-seminar-inquiry-2" data-ajax="false">

					<span id="span-attention-2">ご希望のセミナーが無い場合はこちら</span><br />

					セミナーアンケートにご協力ください <span class="icon-forward"></span>

				</a>

			</div>





            <div id="footer-mobile-new">



				<dl id="footer-mobile-new-menu">

					<dt id="footer-mobile-new-menu_dt_01" style="cursor:pointer"><span>ワーキングホリデー（ワーホリ）で行ける国々</span></dt>

					<dd id="footer-mobile-new-menu_dd_01" style="display:none">

						<ul>

							<li><a href="/country/australia" data-ajax="false">オーストラリア</a></li>

							<li><a href="/visa/v-aus.html" data-ajax="false">オーストラリアビザ情報</a></li>

							<li><a href="/country/newzealand" data-ajax="false">ニュージーランド</a></li>

							<li><a href="/visa/v-nz.html" data-ajax="false">ニュージーランドビザ情報</a></li>

							<li><a href="/country/canada" data-ajax="false">カナダ</a></a></li>

							<li><a href="/visa/v-can.html" data-ajax="false">カナダビザ情報</a></li>

							<li><a href="/country/southkorea" data-ajax="false">韓国</a></li>

							<li><a href="/visa/v-kor.html" data-ajax="false">韓国ビザ情報</a></li>

							<li><a href="/country/france" data-ajax="false">フランス</a></a></li>

							<li><a href="/visa/v-fra.html" data-ajax="false">フランスビザ情報</a></li>

							<li><a href="/country/germany" data-ajax="false">ドイツ</a></li>

							<li><a href="/visa/v-deu.html" data-ajax="false">ドイツビザ情報</a></li>

							<li><a href="/country/unitedkingdom" data-ajax="false">イギリス</a></li>

							<li><a href="/visa/v-uk.html" data-ajax="false">イギリスビザ情報</a></li>

							<li><a href="/country/ireland" data-ajax="false">アイルランド</a></li>

							<li><a href="/visa/v-ire.html" data-ajax="false">アイルランドビザ情報</a></li>

							<li><a href="/country/denmark" data-ajax="false">デンマーク</a></li>

							<li><a href="/visa/v-dnk.html" data-ajax="false">デンマークビザ情報</a></li>

							<li><a href="/country/taiwan" data-ajax="false">台湾</a></li>

							<li><a href="/visa/v-ywn.html" data-ajax="false">台湾ビザ情報</a></li>

							<li><a href="/country/hongkong" data-ajax="false">香港</a></li>

							<li><a href="/visa/v-hkg.html" data-ajax="false">香港ビザ情報</a></li>

							<li><a href="/visa/v-nor.html" data-ajax="false">ノルウェー</a></li>

							<li><a href="/visa/v-nor.html" data-ajax="false">ノルウェービザ情報</a></li>

						</ul>

					</dd>



					<dt id="footer-mobile-new-menu_dt_02" style="cursor:pointer"><span>ワーキング・ホリデーについて知りたい</span></dt>

					<dd id="footer-mobile-new-menu_dd_02" style="display:none">

						<ul>

							<li><a href="/system.html" data-ajax="false">ワーキングホリデー（ワーホリ）制度について</a></li>

							<li><a href="/start.html" data-ajax="false">はじめてのワーキングホリデー（ワーホリ）</a></li>

							<li><a href="/visa/visa_top.html" data-ajax="false">ワーキングホリデー協定国（ビザ情報）</a></li>

						</ul>

					</dd>



					<dt id="footer-mobile-new-menu_dt_03" style="cursor:pointer"><span>国別ワーキングホリデーガイド</span></dt>

					<dd id="footer-mobile-new-menu_dd_03" style="display:none">

						<ul>

							<li><a href="/wh/australia" data-ajax="false">オーストラリアのワーホリ (ワーキングホリデー)</a></li>

							<li><a href="/wh/canada" data-ajax="false">カナダのワーホリ (ワーキングホリデー)</a></li>

							<li><a href="/wh/newzealand" data-ajax="false">ニュージーランドのワーホリ (ワーキングホリデー)</a></li>

							<li><a href="/wh/uk" data-ajax="false">イギリスのワーホリ (ワーキングホリデー)</a></li>

							<li><a href="/wh/america" data-ajax="false">アメリカのワーホリ (ワーキングホリデー)</a></li>

							<li><a href="/country" data-ajax="false">ワーホリ (ワーキングホリデー)協定国情報</a></li>

						</ul>

					</dd>



					<dt id="footer-mobile-new-menu_dt_04" style="cursor:pointer"><span>日本ワーキングホリデー協会について知りたい</span></dt>

					<dd id="footer-mobile-new-menu_dd_04" style="display:none">

						<ul>

							<li><a href="/about.html" data-ajax="false">一般社団法人日本ワーキング・ホリデー協会について</a></li>

							<li><a href="/katsuyou.html" data-ajax="false">日本ワーキングホリデー協会活用ガイド</a></li>

							<li><a href="/mem/register.php" data-ajax="false">メンバー登録をしてサポートを受ける</a></li>

						</ul>

					</dd>



					<dt id="footer-mobile-new-menu_dt_05" style="cursor:pointer"><span>ワーホリの口コミやブログを見たい</span></dt>

					<dd id="footer-mobile-new-menu_dd_05" style="display:none">

						<ul>

							<li><a href="/blog" data-ajax="false">ワーキング・ホリデー協会　公式ブログ</a></li>

							<li><a href="/ja/golden-book" data-ajax="false">Golden-Book(留学・ワーホリ出発前ノート）</a></li>

						</ul>

					</dd>



					<dt id="footer-mobile-new-menu_dt_06" style="cursor:pointer"><span>ワーホリ協会が考える語学留学</span></dt>

					<dd id="footer-mobile-new-menu_dd_06" style="display:none">

						<ul>

							<li><a href="/ryugaku" data-ajax="false">語学留学</a></li>

							<li><a href="/ryugaku/ryugaku_hiyou.html" data-ajax="false">語学留学の費用</a></li>

							<li><a href="/ryugaku/usa_lang.html" data-ajax="false">アメリカ語学留学</a></li>

							<li><a href="/ryugaku/usa_visa.html" data-ajax="false">アメリカ語学留学ビザ</a></li>

							<li><a href="/ryugaku/aus_lang.html" data-ajax="false">オーストラリア語学留学の特徴</a></li>

							<li><a href="/ryugaku/aus_point.html" data-ajax="false">オーストラリア語学留学の良い点</a></li>

							<li><a href="/ryugaku/aus_visa.html" data-ajax="false">オーストラリア語学留学ビザ</a></li>

							<li><a href="/ryugaku/can_lang.html" data-ajax="false">カナダ語学留学</a></li>

							<li><a href="/ryugaku/eng_lang.html" data-ajax="false">イギリス語学留学</a></li>

							<li><a href="/ryugaku/eng_visa.html" data-ajax="false">イギリス語学留学ビザ</a></li>

							<li><a href="/ryugaku/fiji_lang.html" data-ajax="false">フィジー語学留学・フィリピン留学</a></li>

						</ul>

					</dd>



					<dt id="footer-mobile-new-menu_dt_07" style="cursor:pointer"><span>ワーホリ協会が考える大学留学</span></dt>

					<dd id="footer-mobile-new-menu_dd_07" style="display:none">

						<ul>

							<li><a href="/ryugaku/ryugaku_eng.html" data-ajax="false">大学留学に必要な英語力</a></li>

							<li><a href="/ryugaku/usa_sat.html" data-ajax="false">大学留学に必要な英語以外の試験</a></li>

							<li><a href="/ryugaku/usa_univ.html" data-ajax="false">アメリカ大学留学</a></li>

							<li><a href="/ryugaku/aus_univ.html" data-ajax="false">オーストラリア大学留学</a></li>

							<li><a href="/ryugaku/eng_univ.html" data-ajax="false">イギリス大学留学</a></li>

							<li><a href="/ryugaku/ryugaku_jawhm.html" data-ajax="false">留学に向けたワーホリ協会の活用</a></li>

						</ul>

					</dd>



					<dt id="footer-mobile-new-menu_dt_08" style="cursor:pointer"><span>協会のサポートを受けたい</span></dt>

					<dd id="footer-mobile-new-menu_dd_08" style="display:none">

						<ul>

							<li><a href="/mem">協会のサポート内容（メンバー登録）</a></li>

							<li><a href="/seminar/seminar" data-ajax="false">無料セミナー</a></li>

							<li><a href="/kouenseminar.php" data-ajax="false">講演セミナー</a></li>

							<li><a href="/event.html" data-ajax="false">イベントカレンダー</a></li>

							<li><a href="/return.html" data-ajax="false">帰国後のサポート</a></li>

							<li><a href="/qa.html" data-ajax="false">よくある質問</a></li>

							<li><a href="/gogaku-spec.html" data-ajax="false">語学講座</a></li>

							<li><a href="/profile.html" data-ajax="false">講師派遣</a></li>

						</ul>

					</dd>



					<dt id="footer-mobile-new-menu_dt_09" style="cursor:pointer"><span>お役立ち情報</span></dt>

					<dd id="footer-mobile-new-menu_dd_09" style="display:none">

						<ul>

							<li><a href="/info.html" data-ajax="false">お役立ちリンク集</a></li>

							<li><a href="/school.html" data-ajax="false">語学学校（海外・国内）</a></li>

							<li><a href="/service.html" data-ajax="false">サービス（保険・アコモデーション等）</a></li>

						</ul>

					</dd>



					<dt id="footer-mobile-new-menu_dt_10" style="cursor:pointer"><span>海外からのワーキングホリデー</span></dt>

					<dd id="footer-mobile-new-menu_dd_10" style="display:none">

						<ul>

							<li><a href="/attention.html" data-ajax="false">外国人ワーキング・ホリデー青年</a></li>

						</ul>

					</dd>



					<dt id="footer-mobile-new-menu_dt_11" style="cursor:pointer"><span>協賛企業を求めています</span></dt>

					<dd id="footer-mobile-new-menu_dd_11" style="display:none">

						<ul>

							<li><a href="/mem-com.html" data-ajax="false">企業会員について（会員制度ご紹介・意義・メリット）</a></li>

							<li><a href="/adv.html" data-ajax="false">広告掲載のご案内</a></li>

						</ul>

					</dd>



					<dt id="footer-mobile-new-menu_dt_12" style="cursor:pointer"><span>ワーホリ協会のいろいろ</span></dt>

					<dd id="footer-mobile-new-menu_dd_12" style="display:none">

						<ul>

							<li><a href="/volunteer.html" data-ajax="false">ボランティア・インターン募集</a></li>

							<li><a href="/privacy.html" data-ajax="false">個人情報の取り扱い</a></li>

							<li><a href="/about.html#deal" data-ajax="false">特定商取引に関する表記</a></li>

							<li><a href="/sitemap.html" data-ajax="false">サイトマップ</a></li>

						</ul>

					</dd>



					<dt id="footer-mobile-new-menu_dt_13" style="cursor:pointer"><span>アクセス</span></dt>

					<dd id="footer-mobile-new-menu_dd_13" style="display:none">

						<ul>

							<li><a href="/office/tokyo" data-ajax="false">東京オフィス</a></li>

							<li><a href="/office/osaka" data-ajax="false">大阪オフィス</a></li>

							<li><a href="/office/nagoya" data-ajax="false">名古屋オフィス</a></li>

							<li><a href="/office/fukuoka" data-ajax="false">福岡オフィス / カフェバーマンリー</a></li>

							<li><a href="/office/okinawa" data-ajax="false">沖縄オフィス / e-sa(イーサ）</a></li>

						</ul>

					</dd>

				</dl>



				<div id="footer-copyright-new">

					Copyright© JAPAN Association for Working Holiday Makers All right reserved.

				</div>

			</div>



			<div id="mobile-globalmenu-list" style="display:none">

				<ul>

					<li><a href="/system.html" data-ajax="false">ワーキングホリデー制度について</a></li>

					<li><a href="/start.html" data-ajax="false">はじめてのワーホリ</a></li>

					<li><a href="/seminar/seminar" data-ajax="false">無料セミナー</a></li>

					<li><a href="/qa.html" data-ajax="false">よくある質問</a></li>

					<li><a href="/blog/" data-ajax="false">ワーホリブログ</a></li>

					<li><a href="/about.html" data-ajax="false">協会について</a></li>

					<li><a href="/country/" data-ajax="false">ワーホリ協定国</a></li>

					<li><a href="/office/" data-ajax="false">アクセス</a></li>

				</ul>

				<p>

	';





if ($_SESSION['mem_id'] != '' && $_SESSION['mem_name'] != '' && $_SESSION['mem_level'] != -1) {

    $c_footer .= '<img src="/images/mobile/mobile-globalmenu-logout.jpg" class="responsive-img" onClick="fnc_logout();">';
} else {

    $c_footer .= '<a href="/member/" data-ajax="false"><img src="/images/mobile/mobile-globalmenu-login.jpg" class="responsive-img"></a>';
}



$c_footer .= '</p></div>';

/* ↑↑↑ 20141016追加 ↑↑↑ */







$url_home = '/seminar/ser';

$url_top = '/';


$para1 = 'place';
$para2 = isset($_SESSION['para2']) ? $_SESSION['para2'] : 'tokyo';
$request_date = isset($_SESSION['date']) ? $_SESSION['date'] : date('Y-m-d');

//general header

function display_header($h1) {

    $c_header = '



			<!-- ↓↓↓ 20141016追加 ↓↓↓ -->

			<div id="header-box-new">

				<h1 id="header" class="header-new" style="padding-top:12px"><a href="/" data-ajax="false"><img src="/images/mobile/mobile-new-header.gif" class="responsive-img"></a></h1>

				<span id="mobile-globalmenu-btn"><img src="/images/mobile/mobile-globalmenu-btn.gif" class="responsive-img"></span>

			</div>

			<!-- ↑↑↑ 20141016追加 ↑↑↑ -->



		';



    return $c_header;
}

$email = @$_POST['email'];

$pwd = @$_POST['pwd'];

$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if ($email == '' || $pwd == '') {

        $msg = 'メールアドレスとパスワードを入力して下さい。';
    } else {

        try {

            $ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);

            $db = new PDO($ini['dsn'], $ini['user'], $ini['password']);

            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $db->query('SET CHARACTER SET utf8');

            $stt = $db->prepare('SELECT id, email, password, namae FROM memlist WHERE email = :email and state = "5" ');

            $stt->bindValue(':email', $email);

            $stt->execute();

            $cur_id = '';

            $cur_email = '';

            $cur_password = '';

            $cur_namae = '';

            while ($row = $stt->fetch(PDO::FETCH_ASSOC)) {

                $cur_id = $row['id'];

                $cur_email = $row['email'];

                $cur_password = $row['password'];

                $cur_namae = $row['namae'];
            }

            $db = NULL;
        } catch (PDOException $e) {

            die($e->getMessage());
        }

        if ($cur_password == md5($pwd)) {

            // ログインOK

            $_SESSION['mem_id'] = $cur_id;

            $_SESSION['mem_name'] = $cur_namae;

            $_SESSION['mem_level'] = 0;

            $msg = true;
        } else {

            $msg = '入力されたメールアドレスかパスワードに誤りがあります。';
        }
    }
}



if ($msg === true) {

    header("Location: /seminar/ser/id/" . $para2);

    exit;
}



if ($_SESSION['para1'] == 'kouen') {

    $page_tile = '留学・ワーホリ講演セミナー';
} else {



    $page_tile = 'ワーホリ説明会 ';

    if ($para2 == 'tokyo') {
        $page_tile .= '【東京】';
    }

    if ($para2 == 'osaka') {
        $page_tile .= '【大阪】';
    }

    if ($para2 == 'nagoya') {
        $page_tile .= '【名古屋】';
    }

    if ($para2 == 'fukuoka') {
        $page_tile .= '【福岡】';
    }

    if ($para2 == 'okinawa') {
        $page_tile .= '【沖縄】';
    }



    if ($para2 == 'first') {
        $page_tile .= '【初心者セミナー】';
    }

    if ($para2 == 'school') {
        $page_tile .= '【語学学校セミナー】';
    }

    if ($para2 == 'kouen') {
        $page_tile .= '【体験談セミナー】';
    }

    if ($para2 == 'student') {
        $page_tile .= '【情報収集セミナー】';
    }

    if ($para2 == 'foot') {
        $page_tile .= '【人数限定懇談】';
    }

    if ($para2 == 'abili') {
        $page_tile .= '【人気のセミナー】';
    }

    if ($para2 == 'plan') {
        $page_tile .= '【プランニングセミナー】';
    }



    if ($para2 == 'aus') {
        $page_tile = 'オーストラリアの' . $page_tile;
    }

    if ($para2 == 'can') {
        $page_tile = 'カナダの' . $page_tile;
    }

    if ($para2 == 'nz') {
        $page_tile = 'ニュージーランドの' . $page_tile;
    }

    if ($para2 == 'uk') {
        $page_tile = 'イギリスの' . $page_tile;
    }

    if ($para2 == 'fra') {
        $page_tile = 'フランスの' . $page_tile;
    }

    if ($para2 == 'usa') {
        $page_tile = 'アメリカの' . $page_tile;
    }

    if ($para2 == 'other') {
        $page_tile = '色々な国の' . $page_tile;
    }
}

$page_tile .= ' | 日本ワーキングホリデー協会';
?>

<!DOCTYPE html>

<html>

    <head>

        <meta charset="utf-8">

        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

        <meta http-equiv="Pragma" content="no-cache">

        <meta http-equiv="Cache-Control" content="no-cache">

        <meta http-equiv="Expires" content="Thu, 01 Dec 1994 16:00:00 GMT">

        <title><?php echo $page_tile; ?></title>

        <link rel="stylesheet" href="/seminar/css/jquery.mobile-1.0rc2.min.css" />

        <link rel="stylesheet" href="/css/base_mobile.css" />

        <link rel="stylesheet" href="/seminar/css/themes/jawhm.css" />

        <link rel="stylesheet" href="/seminar/css/ser.css" />

        <script src="/seminar/js/jquery.js"></script>

        <script src="/seminar/js/jquery.mobile-1.0rc2.min.js"></script>



        <!-- ↓↓↓ 201411111追加 ↓↓↓ -->

        <link href="/seminar/css/style-m.css" rel="stylesheet" type="text/css" />

        <link href="/seminar/css/style-fonts.css" rel="stylesheet" type="text/css" />

        <link href="/seminar/css/base_mobile_extra.css" rel="stylesheet" type="text/css" />




        <!-- ↓↓↓ 20141016追加 ↓↓↓ -->

        <link href="/css/base_mobile_extra.css" rel="stylesheet" type="text/css" />


        <script type="text/javascript">

            var para1 = '<?php echo $para1 ?>';
            var para2 = '<?php echo $para2 ?>';
            var date = '<?php echo $request_date ?>';

            function load_list_first()
            {
                console.log('load_list_first');
                var msgID = "0-0";

                var msgDate = '';

                var isFull = $('.ui-page-active > .ui-content input[name=isFull]').val();

                console.log("isFull => " + isFull);

                setTimeout($.ajax({
                    type: "POST",
                    url: "/seminar/load_next_ser_bplace.php",
                    async: false,
                    data: "last_msg_id=" + msgID + "&last_msg_date=" + msgDate + "&isFull=" + isFull + "&para1=" + para1 + "&para2=" + para2 + "&date=" + date,
                    success: function (msg) {

                        console.log("f => " + 1 + " => " + $(msg).find(".message_box").size());
                        $(".ui-page-active > .ui-content > #title-top").after(msg);
                        console.log("f => " + 2);
                        $('div[data-role=collapsible]').collapsible();
                        console.log("f => " + 3);
                        $('.ui-page-active > .ui-content > div#title-top').empty();
                        console.log("f => " + 4 + " - " + $(".ui-page-active > .ui-content > .message_box").size());

                        if ($('.ui-page-active > .ui-content #fullari').size()) {
                            $(".ui-page-active #fullsem_flip").css("display", "");
                        } else {
                            $(".ui-page-active #fullsem_flip").css("display", "none");
                        }

                        displayFlip();
                        checkMoreViewButton();
                        console.log(5);
                    },
                    error: function () {

                        alert('通信エラーが発生しました。');

                    },
                }), 2000);

            }


            function last_msg_funtion_for_button()

            {
                console.log("in in in");
                var msgID = $(".ui-page-active > .ui-content .message_box:last").attr("id");

                var msgDate = $(".ui-page-active > .ui-content .message_link:last").attr("alt");



                $('.ui-page-active > .ui-content div#last_msg_loader').html('Loading...<img src="' + location.protocol + '//' + location.host + '/seminar/bigLoader.gif" />');

                var isFull = $('input[name=isFull]').val();

                setTimeout($.ajax({
                    type: "POST",
                    url: "/seminar/load_next_ser_bplace.php",
                    data: "last_msg_id=" + msgID + "&last_msg_date=" + msgDate + "&isFull=" + isFull + "&para1=" + para1 + "&para2=" + para2 + "&date=" + date,
                    success: function (msg) {

                        //alert(msg);
                        //console.log("msg => " + msg);
                        console.log(1 + " => " + $(msg).find(".message_box").size());
                        $(".ui-page-active > .ui-content .message_box:last").after(msg);
                        console.log(2);
                        $('div[data-role=collapsible]').collapsible();
                        console.log(3);
                        $('.ui-page-active > .ui-content div#last_msg_loader').empty();
                        console.log(4 + " - " + $(".ui-page-active > .ui-content > .not-full").size());
                        //if ($(msg).size() > 3 && $(".ui-page-active > .ui-content > .not-full").size() < <?php echo DEFAULT_SEMINAR_COUNT ?>) {
                        //	last_msg_funtion();
                        //}

                        if ($('.ui-page-active > .ui-content #fullari').size()) {
                            $(".ui-page-active #fullsem_flip").css("display", "");
                        } else {
                            $(".ui-page-active #fullsem_flip").css("display", "none");
                        }
                        displayFlip();
//                        checkMoreViewButton();
                        console.log(5);
                    },
                    error: function () {

                        alert('通信エラーが発生しました。');

                    },
                }), 2000);

            }

            function checkMoreViewButton()
            {
                var msgID = $(".ui-page-active .message_box:last").attr("id");
                var msgDate = $(".ui-page-active .message_link:last").attr("alt");
                $.ajax({
                    type: "POST",
                    url: "/seminar/load_next_ser_bplace.php",
                    data: "last_msg_id=" + msgID + "&last_msg_date=" + msgDate + "&para1=" + para1 + "&para2=" + para2 + "&date=" + date,
                    success: function (msg2) {

                        console.log("------------------------------------------" + $(msg2).length);
                        if ($(msg2).length <= 1) {
                            $(".ui-page-active #moreviewbutton").parent().hide();
                        } else {
                            $(".ui-page-active #moreviewbutton").parent().show();
                        }
                    }, error: function () {
                        alert('通信エラーが発生しました。');
                    },
                });
            }

        </script>


        <script type="text/javascript">
            //20150220kawai@plate 満席セミナー表示の制御
            /*
             var hidefull = true;
             function hideFull(){
             $("select#flip-1").change(function(){
             if(hidefull){
             //                    	location.href = location.pathname + "?isFull=on";
             $("head").append('<style type="text/css" class="fullsemcss">.full-seminar{display:block}</style>');
             hidefull = false;
             }else{
             //                    	location.href = location.pathname + "?isFull=off";
             $(".fullsemcss").remove();
             hidefull = true;
             }
             var pos = $(".ui-page-active .legend").position().top;
             $('html,body').animate({
             scrollTop: pos + 80
             }, 1000);
             });
             }
             */

            function displayFlip() {

                /*
                 if($(".ui-page-active > .ui-content > .full-seminar").size() == 0){
                 
                 $(".ui-page-active #fullsem_flip").css("display", "none");
                 } else {
                 
                 $(".ui-page-active #fullsem_flip").css("display", "");
                 }
                 */

            }

            $(document).bind("pageload", function (e, data) {
//                hidefull = true;
//                $(".fullsemcss").remove();
//                hideFull();
                //displayFlip();
            });
            $(document).ready(function () {
                //displayFlip();
//                hideFull();

            });
            $(document).bind("pagechange", function () {
                $('input[name=isFull]').val('0');
                $(".ui-page-active #fullsem_flip").css("display", "none");
                $(".ui-page-active > .ui-content select#flip-1").change(function () {

                    // youso sakujo
                    $(".ui-page-active .separate-date-bloc").remove();
                    $(".ui-page-active .title-date").remove();
                    $(".ui-page-active .message_box").remove();
                    if ($('input[name=isFull]').val() == '1') {
                        $('input[name=isFull]').val('0');
                    } else {
                        $('input[name=isFull]').val('1');
                    }
                    load_list_first();
                    var pos = $(".ui-page-active .legend").position().top;
                    $('html,body').animate({
                        scrollTop: pos + 80
                    }, 1000);
                });

                if ($(".ui-page-active #jqm-homeheader").html()) {
                } else {

                    if ($('input[name=isFull]').val() == '1') {

                    } else {

                    }

                    load_list_first();
                    //displayFlip();
                    //checkMoreViewButton();
                }
                /*
                 if ($(".ui-page-active > .ui-content > .not-full").size() < <?php echo DEFAULT_SEMINAR_COUNT ?>) {
                 //if ($(".ui-page-active #jqm-homeheader").html()) {
                 //} else {
                 //last_msg_funtion();
                 //}
                 } else {
                 $(".ui-page-active #fullsem_flip").css("display", "none");
                 }
                 */
            });


            jQuery("#footer-mobile-new-menu_dd_01").slideToggle("fast");

            $("#mobile-globalmenu-btn").live('click', function () {

                $.mobile.activePage.find("#mobile-globalmenu-list").slideToggle('fast', function () {
                    if ($("#mobile-globalmenu-list").css("display") == "none") {
                        //閉じた時-- Google Analytics
                        _gaq.push(['_trackEvent', 'button', 'click', 'menu-closed']);
                    } else {
                        //開いた時-- Google Analytics
                        _gaq.push(['_trackEvent', 'button', 'click', 'menu-opened']);
                    }
                });

                return false;

            });

            $("#mobile-globalmenu-list ul li a").live('click', function () {
                //メニュー項目のクリック時-- Google Analytics
                var href = $("#mobile-globalmenu-list ul li a").attr('href');
                //ga('send', 'event', 'link', 'click', href);
            });



            /*
             
             $("#footer-mobile-new-menu dt").live('click', function(){
             
             var dt_index = $("#footer-mobile-new-menu dt").index(this);
             
             //$.mobile.activePage.find("#footer-mobile-new-menu dd").eq(dt_index).slideToggle('fast');
             
             return false;
             
             });
             
             */

            /* $("#footer-mobile-new-menu_dt_01").live('click', function(){
             
             $.mobile.activePage.find("#footer-mobile-new-menu_dd_01").slideToggle('fast');
             
             return false;
             
             });*/

            jQuery("#footer-mobile-new-menu_dt_01").live('click', function () {

                jQuery("#footer-mobile-new-menu_dd_01").slideToggle("fast");

                return false;

            });



            $("#footer-mobile-new-menu_dt_02").live('click', function () {

                $.mobile.activePage.find("#footer-mobile-new-menu_dd_02").slideToggle('fast');

                return false;

            });



            $("#footer-mobile-new-menu_dt_03").live('click', function () {

                $.mobile.activePage.find("#footer-mobile-new-menu_dd_03").slideToggle('fast');

                return false;

            });



            $("#footer-mobile-new-menu_dt_04").live('click', function () {

                $.mobile.activePage.find("#footer-mobile-new-menu_dd_04").slideToggle('fast');

                return false;

            });



            $("#footer-mobile-new-menu_dt_05").live('click', function () {

                $.mobile.activePage.find("#footer-mobile-new-menu_dd_05").slideToggle('fast');

                return false;

            });



            $("#footer-mobile-new-menu_dt_06").live('click', function () {

                $.mobile.activePage.find("#footer-mobile-new-menu_dd_06").slideToggle('fast');

                return false;

            });



            $("#footer-mobile-new-menu_dt_07").live('click', function () {

                $.mobile.activePage.find("#footer-mobile-new-menu_dd_07").slideToggle('fast');

                return false;

            });



            $("#footer-mobile-new-menu_dt_08").live('click', function () {

                $.mobile.activePage.find("#footer-mobile-new-menu_dd_08").slideToggle('fast');

                return false;

            });



            $("#footer-mobile-new-menu_dt_09").live('click', function () {

                $.mobile.activePage.find("#footer-mobile-new-menu_dd_09").slideToggle('fast');

                return false;

            });



            $("#footer-mobile-new-menu_dt_10").live('click', function () {

                $.mobile.activePage.find("#footer-mobile-new-menu_dd_10").slideToggle('fast');

                return false;

            });



            $("#footer-mobile-new-menu_dt_11").live('click', function () {

                $.mobile.activePage.find("#footer-mobile-new-menu_dd_11").slideToggle('fast');

                return false;

            });



            $("#footer-mobile-new-menu_dt_12").live('click', function () {

                $.mobile.activePage.find("#footer-mobile-new-menu_dd_12").slideToggle('fast');

                return false;

            });



            $("#footer-mobile-new-menu_dt_13").live('click', function () {

                $.mobile.activePage.find("#footer-mobile-new-menu_dd_13").slideToggle('fast');

                return false;

            });

        </script>

        <!-- ↑↑↑ 20141016追加 ↑↑↑ -->












        <script>

            function zentohan(inst) {

                var han = '1234567890abcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyz@-.';

                var zen = '１２３４５６７８９０ａｂｃｄｅｆｇｈｉｊｋｌｍｎｏｐｑｒｓｔｕｖｗｘｙｚＡＢＣＤＥＦＧＨＩＪＫＬＭＮＯＰＱＲＳＴＵＶＷＸＹＺ＠－．';

                var word = inst;

                for (i = 0; i < zen.length; i++) {

                    var regex = new RegExp(zen[i], "gm");

                    word = word.replace(regex, han[i]);

                }

                return word;

            }



            function fncyoyaku() {



                // 入力チェック

                if (!jQuery('#namae').val()) {

                    alert('お名前を入力してください。');

                    jQuery('#namae').focus();

                    return false;

                }

                if (!jQuery('#furigana').val()) {

                    alert('フリガナを入力してください。');

                    jQuery('#furigana').focus();

                    return false;

                }

                if (!jQuery('#email').val()) {

                    alert('メールアドレスを入力してください。');

                    jQuery('#email').focus();

                    return false;

                }

                jQuery('#email').val(zentohan(jQuery('#email').val()));

                var strMail = jQuery('#email').val();

                if (!strMail.match(/.+@.+\..+/)) {

                    alert('メールアドレスを確認してください。');

                    jQuery('#email').focus();

                    return false;

                }

                if (!jQuery('#tel').val()) {

                    alert('お電話番号を入力してください。');

                    jQuery('#tel').focus();

                    return false;

                }/*else if(jQuery('#tel').val()[0] != '0'){
                 
                 alert('お電話番号を正しく入力してください');
                 
                 jQuery('#tel').focus();
                 
                 return false;
                 
                 }*/



                jQuery('#yoyakubtn').val('予約処理中...');

                //jQuery('#yoyakubtn').button('disable');

                $senddata = $("#form_yoyaku").serialize();

                $.ajax({
                    type: "POST",
                    url: "/yoyaku/yoyaku.php",
                    data: $senddata,
                    success: function (msg) {

                        alert(msg);

                        location.href = '<?php print $url_home; ?>';

                    },
                    error: function () {

                        alert('通信エラーが発生しました。');

                    }

                });



                return false;

            }



            //Action after Select option button in seminarpage list

            $('.select-choice').live('change', function (e) {

                $.mobile.changePage($(this).val(), {transition: "fade"});

                //		$('.select-choice').listview('refresh');

            });



            function fnc_logout()

            {

                if (confirm("ログアウトしますか？"))

                {

                    location.href = "/member/logout.php";

                }

            }

        </script>

        <script type="text/javascript" src="/js/taglogscript.js"></script>
        <script type="text/javascript">
            (function () {
                var spUserAgentList = ["Android", "iPhone", "iPod", "iPad", "IEMobile", "BlackBerry", "Symbian OS", "Windows Phone", "KFOT", "KFTT", "KFJWI"];
                var smartPhoneFlag = false;
                var userAgent = navigator.userAgent;
                for (var i in spUserAgentList) {
                    smartPhoneFlag = (userAgent.indexOf(spUserAgentList[i]) != -1);
                    if (smartPhoneFlag)
                        break;
                }
                var taglogUrl = "https://www.taglog.jp/" + ((smartPhoneFlag) ? "taglog2-sp.js" : "taglog2.js");
                $script(taglogUrl, "taglog");
                $script.ready("taglog", function () {
                    taglog.init("https://www.jawhm.or.jp/");
                    taglog.pageAnalyzer.start();
                    taglog.clickMonitor.start();
                });
            })();
        </script>
        <!-- Google Analytics -->
        <script type="text/javascript" src="http://<?php echo $_SERVER['SERVER_NAME'] ?>/js/google-analytics.js"></script>
    </head>

    <body>


        <?php
//        echo '<pre style="height: 100px;width:100%;padding:10px;border: 10px ridge #333;background:#fff;position: absolute;z-index: 9999;overflow-y:auto;top:30%;">';
//        var_dump($para1);
//        var_dump($para2);
//        var_dump($para3);
//        var_dump($para4);
//        echo '</pre>';
        ?>

        <?php
        if ($para1 == 'login') {
            ?>

            <div data-role="page" id="loginpage" class="jquery">

                <?php
                print display_header('セミナー予約フォーム（ログイン）');
                ?>

                <p id="topicpath">

                    <a href="<?php echo $url_top; ?>" data-ajax="false">ワーキング・ホリデー協会</a>&nbsp;&gt;&nbsp;<a href="<?php print $url_home; ?>" data-inline="true">無料セミナーを探そう</a>&nbsp;&gt;&nbsp;ログイン

                </p>

                <div data-role="content">

                    <h2 class="title-city">ログイン</h2>

                    <p class="text01">

                        メンバー専用ページにログインします。<br>

                        ご登録頂いた、メールアドレスとパスワードでログインしてください。

                    </p>

                    <?php
                    if (!empty($msg)) :
                        ?>

                        <p style="color: #ff0000;"><?php echo $msg; ?></p>

                        <?php
                    endif;
                    ?>

                    <div style="border: 1px dotted navy; margin: 20px 0 10px 0; padding: 10px 10px 10px 10px; font-size:11pt;">

                        <form action="/seminar/ser/login/<?php echo $para2; ?>" method="post">

                            <input type="hidden" name="act" value="login">

                            <p class="text01" style="text-align:left;">

                                メールアドレス&nbsp;<input type="text" size="30" name="email" value="<?php echo htmlspecialchars(@$_POST['email']); ?>">&nbsp;<br>

                                パスワード&nbsp;<input type="password" size="20" name="pwd" value="<?php echo htmlspecialchars(@$_POST['pwd']); ?>">&nbsp;<br><br>

                                <input type="submit" value="　ログイン　">

                            </p>

                        </form>

                    </div>

                    <br>

                    <a href="/seminar/ser/" data-role="button" data-inline="true" data-rel="back" data-theme="a">戻る</a>

                    <br>
                    

                </div>

                <?php print $c_footer; ?>

            </div>

            <?php
        }

        else {

            // 各ページを表示
            ?>


            <div data-role="page" id="serpage<?php print $para1 . $para2 . $para3; ?>" class="jquery">

                <?php
                print display_header('無料セミナーを探そう');
                ?>

                <div data-role="content">

                    <?php
                    if ($para3 == '')
                        $para3 = 'tokyo';



                    if (($para1 == 'know' && $para4 == '') || ($para1 == 'country' && $para4 == ''))
                        $para4 = 'all';
                    ?>

                    <div class="smlBanner" style="margin-bottom:8px;">

                        <?php echo $ser_banner[$para3]; ?>

                    </div>

                    <div style="margin:8px 0 12px 0;" class="ui-body ui-body-d">
                        <div style="font-size: 12px;font-weight: bold;text-align: center;padding: 10px 0px;">
                            セミナーの仮予約ありがとうございました。
                        </div>
                    </div>

                    <div style="margin:8px 0 12px 0; text-align: center">
                        <img src="/css/images/tri.png" style="vertical-align: top">
                        <p style="display: inline-block">
                            当日はその他にもセミナーが開催されます。<br/>
                            よろしければ、ご予約の上、併せてご参加ください。
                        </p>
                    </div>

                    <?php
                    switch ($para1 . $para2) {

                        case 'placetokyo':

                            print '<h2 class="title-city">東京会場のセミナー</h2>';

                            print '<p><img src="http://www.jawhm.or.jp/css/images/googlemap16.png"><a href="/event/map/pc.php?p=tokyo" target="_blank">会場のご案内</a> TEL:<a href="tel:03-6304-5858">03-6304-5858</a></p>';

                            break;

                        case 'placeosaka':

                            print '<h2 class="title-city">大阪会場のセミナー</h2>';

                            print '<p><img src="http://www.jawhm.or.jp/css/images/googlemap16.png"><a href="/event/map/pc.php?p=osaka" target="_blank">会場のご案内</a> TEL:<a href="tel:06-6346-3774">06-6346-3774</a></p>';

                            break;

                        case 'placesendai':

                            print '<h2 class="title-city">仙台会場のセミナー</h2>';

                            break;

                        case 'placetoyama':

                            print '<h2 class="title-city">富山会場のセミナー</h2>';

                            break;

                        case 'placefukuoka':

                            print '<h2 class="title-city">福岡会場のセミナー</h2>';

                            break;

                        case 'placenagoya':

                            print '<h2 class="title-city">名古屋会場のセミナー</h2>';

                            print '<p><img src="http://www.jawhm.or.jp/css/images/googlemap16.png"><a href="/event/map/pc.php?p=nagoya" target="_blank">会場のご案内</a> TEL:<a href="tel:052-462-1585">052-462-1585</a></p>';

                            break;

                        case 'placeokinawa':

                            print '<h2 class="title-city">沖縄会場のセミナー</h2>';

                            break;

                        case 'placeevent':

                            print '<h2 class="title-city">イベント情報</h2>';

                            break;
                    }
                    ?>

                    <br/>

                    <!--  -->


                    <div class="legend">

                        <p><strong>【アイコンの意味】</strong><br/>

                            <span style="margin-left:20px;"><img src="/css/images/au.png" alt="Australian Flag" />&nbsp;<img src="/css/images/ca.png" alt="Canadian Flag" />&nbsp;<img src="/css/images/uk.png" alt="Union Jack" />&nbsp;&nbsp;国別セミナー</span>

                            <span style="margin-left:20px;"><img src="/css/images/wd.png" alt="World" />&nbsp;&nbsp;英語圏セミナー</span>

                            <span style="margin-left:20px;"><img src="/css/images/hoshi.png" alt="osusume" />&nbsp;&nbsp;おススメ</span>

                            <span style="margin-left:20px;"><img src="/css/images/full.png" alt="fullybooked" />&nbsp;&nbsp;満席</span>

                            <span style="margin-left:20px;"><img src="/css/images/camera.png" alt="camera" />&nbsp;&nbsp;中継対象</span><br/>

                        </p>

                    </div>

                    <div id="title-top">Loading...<img src="/seminar/bigLoader.gif" /></div>

                    <!--                    <div id="fullsem_flip">
                                            <span id="mes">満席セミナー表示</span>
                                            <div style="width: 100px">
                                                <input type="hidden" name="isFull" value="<?php ($_GET['isFull'] == 'on') ? '1' : '0'; ?>" />
                                                <select name="flip-1" id="flip-1" data-role="slider">
                                                    <option value="off">OFF</option>
                                                    <option value="on">ON</option>
                                                </select>
                                            </div>
                                        </div>-->


                    <div class="" style="clear: both;"></div>
                    <!--<button type="button" id="moreviewbutton" onclick="last_msg_funtion_for_button()">もっと見る</button>-->

                    <div id="last_msg_loader"></div>



<!--                    <p>

                        セミナーに参加されるほとんどの方が、お一人でのご参加です。<br/>

                        どうぞ、お気軽にご予約の上、ご参加ください。<br/>

                    </p>-->
                    
                    <ul data-role="listview" data-inset="true" data-theme="a" data-dividertheme="a">

                        <li data-role="list-divider">内容からセミナーを探す</li>

                        <li data-icon="arrow-r-lblue" id="first-btn"><a href="/seminar/ser/know/first"><img src="/images/seminaryoyaku/syoshinsya.png" alt="" class="ui-li-icon" />初心者セミナー</a></li>

                        <li data-icon="arrow-r-orange" id="plan-btn"><a href="/seminar/ser/know/plan"><img src="/images/seminaryoyaku/planning.png" alt="" class="ui-li-icon" />プランニング法セミナー</a></li>

                        <li data-icon="arrow-r-pink" id="student-btn"><a href="/seminar/ser/know/student"><img src="/images/seminaryoyaku/jouhou.png" alt="" class="ui-li-icon" />情報収集セミナー</a></li>

                        <li data-icon="arrow-r-orange" id="foot-btn"><a href="/seminar/ser/know/foot"><img src="/images/seminaryoyaku/kondan.png" alt="" class="ui-li-icon" />人数限定！懇談セミナー</a></li>

                        <li data-icon="arrow-r-yellow" id="kouen-btn"><a href="/seminar/ser/know/kouen"><img src="/images/seminaryoyaku/taikendan.png" alt="" class="ui-li-icon" />体験談セミナー</a></li>

                        <li data-icon="arrow-r-dblue" id="school-btn"><a href="/seminar/ser/know/school"><img src="/images/seminaryoyaku/school.png" alt="" class="ui-li-icon" />語学学校セミナー</a></li>

                        <li data-icon="arrow-r-green" id="abili-btn"><a href="/seminar/ser/know/abili"><img src="/images/seminaryoyaku/chumoku.png" alt="" class="ui-li-icon" />注目！！人気のセミナー</a></li>

                        <li data-icon="arrow-r-red" id="member-btn"><a href="/seminar/ser/page/member"><img src="/seminar/css/themes/images/icon7-18x18.png" alt="" class="ui-li-icon" />メンバー限定セミナー</a></li>

                        <li id="all-btn"><a href="/seminar/ser/know/all">全て</a></li>

                    </ul>



                    <ul data-role="listview" data-inset="true" data-theme="a" data-dividertheme="a">

                        <li data-role="list-divider">興味のある国からセミナーを探す</li>

                    </ul>



                    <div class="ui-grid-b">

                        <div class="ui-block-a"><a href="/seminar/ser/country/aus" data-mini="true" data-role="button" data-theme="d"><img src="/images/flag01.gif" /><span class="smaller-text">オーストラリア</span></a></div>

                        <div class="ui-block-b"><a href="/seminar/ser/country/can" data-mini="true" data-role="button" data-theme="d"><img src="/images/flag03.gif" /><span class="smaller-text">カナダ</span></a></div>

                        <div class="ui-block-c"><a href="/seminar/ser/country/nz" data-mini="true" data-role="button" data-theme="d"><img src="/images/flag02.gif" /><span class="smaller-text">ニュージーランド</span></a></div>

                    </div>

                    <div class="ui-grid-b">

                        <div class="ui-block-a"><a href="/seminar/ser/country/uk"  data-role="button" data-theme="d"><img src="/images/flag07.gif" /><span class="smaller-text">イギリス</span></a></div>

                        <div class="ui-block-b"><a href="/seminar/ser/country/fra"  data-role="button" data-theme="d"><img src="/images/flag05.gif" /><span class="smaller-text">フランス</span></a></div>

                        <div class="ui-block-c"><a href="/seminar/ser/country/usa" data-role="button" data-theme="d"><img src="/images/seminaryoyaku/america.png" /><span class="smaller-text">アメリカ</span></a></div>

                    </div>

                    <div class="ui-grid-solo">

                        <div class="ui-block-a"><a href="/seminar/ser/country/other" data-role="button" data-theme="d"><img src="/images/earth-medium.png" /><span class="smaller-text">その他</span></a></div>

                    </div>


                    <?php print $c_footer; ?>





                </div>

                <?php
            }
            ?>

    </body>
</html>

