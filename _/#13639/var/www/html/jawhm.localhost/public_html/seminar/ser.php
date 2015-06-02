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

$url_thankyou = '/seminar/thankyou';

$url_top = '/';



if ($para1 <> 'id') {

    $_SESSION['para1'] = $para1;

    $_SESSION['para2'] = $para2;

    $_SESSION['para3'] = $para3;

    $_SESSION['para4'] = $para4;

    $_SESSION['para5'] = $para5;

    $_SESSION['para6'] = $para6;
}

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

if ($para1 == 'douji') {

    $ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);

    $db = new PDO($ini['dsn'], $ini['user'], $ini['password']);

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $db->query('SET CHARACTER SET utf8');

    $stt = $db->prepare('SELECT * FROM event_list WHERE id = :id');

    $stt->bindValue(':id', $para2);

    $stt->execute();

    $seminar_info = $stt->fetch();



    $stt = $db->prepare('select *,date_format(starttime, \'%c月%e日 (%a) %k:%i\') as start from event_list where hiduke = :hiduke and starttime = :starttime and k_title1 = :k_title1 order by id');

    $stt->bindValue(':hiduke', $seminar_info['hiduke']);

    $stt->bindValue(':starttime', $seminar_info['starttime']);

    $stt->bindValue(':k_title1', $seminar_info['k_title1']);

    $stt->execute();

    $douji_list = array();

    while ($row = $stt->fetch(PDO::FETCH_ASSOC)) {

        $douji_list[] = $row;
    }

    if (count($douji_list) < 2) {

        header("Location: /seminar/ser/id/" . $para2);

        exit;
    }
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

            function load_list_first()
            {
                console.log('load_list_first');
                var msgID = "0-0";

                var msgDate = '';

                var isFull = $('.ui-page-active > .ui-content input[name=isFull]').val();

                console.log("isFull => " + isFull);

                setTimeout($.ajax({
                    type: "POST",
                    url: "/seminar/load_next_ser.php",
                    async: false,
                    data: "last_msg_id=" + msgID + "&last_msg_date=" + msgDate + "&isFull=" + isFull,
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

            function last_msg_funtion()
            {
                var msgID = $(".ui-page-active > .ui-content .message_box:last").attr("id");

                var msgDate = $(".ui-page-active > .ui-content .message_link:last").attr("alt");



                $('.ui-page-active > .ui-content div#last_msg_loader').html('Loading...<img src="' + location.protocol + '//' + location.host + '/seminar/bigLoader.gif" />');

                var isFull = $('.ui-page-active > .ui-content input[name=isFull]').val();

                setTimeout($.ajax({
                    type: "POST",
                    url: "/seminar/load_next_ser.php",
                    data: "last_msg_id=" + msgID + "&last_msg_date=" + msgDate + "&isFull=" + isFull,
                    success: function (msg) {

                        //alert(msg);
                        /*
                         $(".message_box:last").after(msg);
                         
                         $('div[data-role=collapsible]').collapsible();
                         
                         $('div#last_msg_loader').empty();
                         
                         if ($(".ui-page-active > .ui-content > .not-full").size() < 15) {
                         last_msg_funtion();
                         displayFlip();
                         }
                         */
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
                        checkMoreViewButton();
                        console.log(5);
                    },
                    error: function () {

                        alert('通信エラーが発生しました。');

                    },
                }), 2000);

            }
            ;

            /*
             
             //スクロールによるリストの更新
             
             $(document).bind("scrollstop", function() {
             
             //alert("stopped scrolling");
             
             //alert( ($(window).scrollTop()+100) +' compare '+ ($(document).height()- $(window).height()));
             
             
             
             if (($(window).scrollTop()+100) > ($(document).height() - $(window).height())){
             
             
             
             //alert('bottom');
             
             var lastcount =	$(".title-date:last").attr("title");
             
             
             
             if(lastcount >= 5) // check if there is more content to dislay (avoid loading more
             
             {
             
             last_msg_funtion();
             
             }
             
             
             
             }
             
             });
             
             */

            function last_msg_funtion_for_button()

            {
                console.log("in in in");
                var msgID = $(".ui-page-active > .ui-content .message_box:last").attr("id");

                var msgDate = $(".ui-page-active > .ui-content .message_link:last").attr("alt");



                $('.ui-page-active > .ui-content div#last_msg_loader').html('Loading...<img src="' + location.protocol + '//' + location.host + '/seminar/bigLoader.gif" />');

                var isFull = $('input[name=isFull]').val();

                setTimeout($.ajax({
                    type: "POST",
                    url: "/seminar/load_next_ser.php",
                    data: "last_msg_id=" + msgID + "&last_msg_date=" + msgDate + "&isFull=" + isFull,
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
                        checkMoreViewButton();
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
                    url: "/seminar/load_next_ser.php",
                    data: "last_msg_id=" + msgID + "&last_msg_date=" + msgDate,
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

//                        alert(msg);

                        location.href = '<?php print $url_thankyou; ?>';

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
        if ($para1 == '') {

            // トップページを表示
            ?>



            <div data-role="page" id="toppage" class="jquery">

                <?php
                print display_header('無料セミナーを探そう');
                ?>

                <p id="topicpath"><a href="<?php echo $url_top; ?>" data-ajax="false">ワーキング・ホリデー協会</a>&nbsp;&gt;&nbsp;無料セミナー情報</p>

                <div data-role="content">



                    <div class="smlBanner">

                        <?php echo $ser_banner['all']; ?>

                    </div>



                    <ul data-role="listview" data-inset="true" data-theme="a" data-dividertheme="a">

                        <li data-role="list-divider">ワーホリ・留学の無料セミナー</li>

                    </ul>



                    <div id="jqm-homeheader">

                        <p>きっと見つかる　あなたにピッタリの無料セミナー</p>

                    </div>

                    <p class="intro">日本ワーキング・ホリデー協会が随時開催している無料セミナーに参加して、留学・ワーホリの色々な情報をGETしよう！！</p>



                    <ul data-role="listview" data-inset="true" data-theme="a" data-dividertheme="a">

                        <li data-role="list-divider">開催地からセミナーを探す</li>

                    </ul>



                    <div class="ui-grid-a large-text">

                        <div class="ui-block-a"><a href="/seminar/ser/place/tokyo<?php echo ($use_area) ? '/area' : ''; ?>" data-mini="true" data-role="button" data-theme="d">東京</a></div>

                        <div class="ui-block-b"><a href="/seminar/ser/place/osaka<?php echo ($use_area) ? '/area' : ''; ?>" data-mini="true" data-role="button" data-theme="d">大阪</a></div>

                    </div>



                    <div class="ui-grid-a large-text">

                        <div class="ui-block-a"><a href="/seminar/ser/place/nagoya<?php echo ($use_area) ? '/area' : ''; ?>" data-mini="true" data-role="button" data-theme="d">名古屋</a></div>

                        <div class="ui-block-b"><a href="/seminar/ser/place/fukuoka<?php echo ($use_area) ? '/area' : ''; ?>" data-mini="true" data-role="button" data-theme="d">福岡</a></div>

                    </div>



                    <div class="ui-grid-a large-text">

                        <div class="ui-block-a"><a href="/seminar/ser/place/okinawa<?php echo ($use_area) ? '/area' : ''; ?>" data-mini="true" data-role="button" data-theme="d">沖縄</a></div>

                        <div class="ui-block-b"><a href="/seminar/ser/place/event<?php echo ($use_area) ? '/area' : ''; ?>" data-mini="true" data-role="button" data-theme="d">その他</a></div>

                    </div>



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



                </div>

                <?php print $c_footer; ?>

            </div>



            <?php
        }

        if ($para1 == 'id') {

            // 予約ページを表示
            ?>

            <div data-role="page" id="yoyaku<?php print $para1; ?>" class="jquery">

                <?php
                print display_header('セミナー予約フォーム');
                ?>

                <p id="topicpath">

                    <?php
                    if ($_SESSION['para1'] == 'kouen') {
                        ?>

                        <a href="<?php echo $url_top; ?>" data-ajax="false">ワーキング・ホリデー協会</a>&nbsp;&gt;&nbsp;<a href="/kouenseminar.php" data-ajax="false" data-inline="true">留学・ワーホリ講演セミナー</a>&nbsp;&gt;&nbsp;セミナー予約フォーム

                        <?php
                    } else {
                        ?>

                        <a href="<?php echo $url_top; ?>" data-ajax="false">ワーキング・ホリデー協会</a>&nbsp;&gt;&nbsp;<a href="<?php print $url_home; ?>">無料セミナーを探そう</a>&nbsp;&gt;&nbsp;セミナー予約フォーム

                    <?php }
                    ?>

                </p>



                <div data-role="content" data-theme="a">



                    <h2>ご参加予定のセミナー</h2>



                    <?php
                    $formon = false;



                    try {

                        $ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);

                        $db = new PDO($ini['dsn'], $ini['user'], $ini['password']);

                        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                        $db->query('SET CHARACTER SET utf8');

                        $rs = $db->query('SELECT id, year(hiduke) as yy, month(hiduke) as mm, day(hiduke) as dd, date_format(starttime, \'%c月%e日 (%a) %k:%i\') as start, date_format(starttime, \'%k:%i\') as starttime, title, memo, place, k_use, k_title1, k_desc1, k_desc2, k_stat, free, pax, booking, beginer FROM event_list WHERE id = ' . $para2);

                        $cnt = 0;

                        $place_name = "";

                        while ($row = $rs->fetch(PDO::FETCH_ASSOC)) {

                            $formon = true;



                            $cnt++;

                            $year = $row['yy'];

                            $month = $row['mm'];

                            $day = $row['dd'];



                            $start = $row['start'] . '～';

                            //$start	= mb_ereg_replace('Mon', '月', $start);
                            //$start	= mb_ereg_replace('Tue', '火', $start);
                            //$start	= mb_ereg_replace('Wed', '水', $start);
                            //$start	= mb_ereg_replace('Thu', '木', $start);
                            //$start	= mb_ereg_replace('Fri', '金', $start);
                            //$start	= mb_ereg_replace('Sat', '土', $start);
                            //$start	= mb_ereg_replace('Sun', '日', $start);

                            $title = $row['k_title1'];

                            $beginer = $row['beginer'];



                            if ($row['free'] == 1) {

                                // 有料セミナー

                                if ($_SESSION['mem_id'] != '' && $_SESSION['mem_name'] != '' && $_SESSION['mem_level'] != -1) {

                                    $formon = true;
                                } else {

                                    // 未ログイン

                                    $formon = false;

                                    print '<a target="_blank" href="' . $url_top . 'member" data-role="button" data-rel="back" data-theme="a">ご予約にはログインが必要です</a>';
                                }
                            }

//			$c_desc = $row['k_desc1'];

                            $c_desc = strip_tags($row['k_desc1'], '<font><b><table><tr><td><img>');





                            if ($row['k_stat'] == 1) {

                                if ($row['booking'] >= $row['pax']) {

//					$formon = false;

                                    $c_img = '[満席です。キャンセル待ちとなります。]';
                                } else {

                                    $c_img = '[残席わずかです。ご予約はお早めに]';
                                }
                            } elseif ($row['k_stat'] == 2) {

                                $formon = false;

                                $c_img = '[満席です]';
                            } else {

                                if ($row['booking'] >= $row['pax']) {

//					$formon = false;

                                    $c_img = '[満席です。キャンセル待ちとなります。]';
                                } else {

                                    if ($row['booking'] >= $row['pax'] / 3) {

                                        $c_img = '[残席わずかです。ご予約はお早めに]';
                                    } else {

                                        $c_img = '';
                                    }
                                }
                            }



                            print '<div data-role="content" data-collapsed="true" data-theme="a">';

                            print '<div style="color:red; font-weight:bold;">' . $c_img . '</div>';



                            print '<table>';

                            print '<tr><td style="vertical-align:top;"><img src="/seminar/images/tama_04.gif"></td><td style="vertical-align:top;">';

                            /*

                              switch($row['place'])	{

                              case 'tokyo':

                              $place = '東京';

                              break;

                              case 'osaka':

                              $place = '大阪';

                              break;

                              case 'fukuoka':

                              $place = '福岡';

                              break;

                              case 'sendai':

                              $place = '仙台';

                              break;

                              case 'toyama':

                              $place = '富山';

                              break;

                              case 'okinawa':

                              $place = '沖縄';

                              break;

                              case 'nagoya':

                              $place = '名古屋';

                              break;

                              case 'event':

                              $place = 'イベント';

                              break;

                              }

                             */



                            $place = "";

                            if ($row['place'] == 'event') {

                                $place = translate_city($row['k_desc2']);

                                if (empty($place)) {

                                    $place = translate_city($row['place']);
                                } else {

                                    $place_name = $place;

                                    $place .= "会場";
                                }

                                $para_place = $row['k_desc2'];
                                if (empty($para_place)) {
                                    $para_place = $row['place'];
                                }
                                $para_place = $row['place'];
                                $_SESSION['para2'] = $para_place;
                            } else {

                                $place = translate_city($row['place']);

                                $para_place = $row['place'];
                                $_SESSION['para2'] = $para_place;
                            }

                            $_SESSION['date'] = $year . '-' . str_pad($month, 2, 0, STR_PAD_LEFT) . '-' . str_pad($day, 2, 0, STR_PAD_LEFT);


                            if ($row['place'] <> 'event') {

                                print $place . '会場</td></tr>';
                            } else {

                                print $place . '（会場を必ずご確認の上、ご予約ください）</td></tr>';
                            }

                            print '<tr><td style="vertical-align:top;"><img src="/seminar/images/tama_04.gif"></td><td style="vertical-align:top;">' . $start . '</td></tr>';

                            print '<tr><td style="vertical-align:top;"><img src="/seminar/images/tama_04.gif"></td><td style="vertical-align:top;">' . $title . '</td></tr>';

                            print '</table>';

                            if ($beginer !== '1') {

                                print '<div style="background-color:LightPink; font-size:10pt; color:black; font-weight:bold; margin:6px 0 0 0; padding: 3px 5px 3px 5px;">';

                                print '　【　ご注意　】<br/>';

                                print '初めてセミナーご参加される場合は、<a href="/seminar/ser/know/first" target="_blank">初心者向けセミナー</a>へのご予約をお願いします。<br/>';

                                print '</div>';
                            }



                            print '</div>';



                            print '<div style="margin:8px 0 12px 0;">';

                            print '<p style="color:red;">';

                            print '最近、会場を間違えてご予約される方が増えております。<br/>';

                            print 'セミナー内容、会場、日程等を十分ご確認の上、ご予約頂けますようお願い申し上げます。';

                            print '</p>';

                            print '</div>';
                        }
                    } catch (PDOException $e) {

                        die($e->getMessage());
                    }



                    if ($para3 == 'area') {



                        $formon = false;
                        ?>

                        <p><br><br>

                            【ご注意】

                            <br><br>

                            このセミナーは、<span style="text-decoration: underline"><?php echo $title; ?></span>です。<br><br>

                            <?php
                            if (!empty($place_name)) :

                                echo 'このセミナーは<span style="font-size: 24px;">「' . $place_name . '」</span>の会場にて開催されます。<br><br>';

                            endif;
                            ?>

                            会場にお間違いは無いでしょうか？<br><br>

                            よろしければ「次へ」を押して下さい。<br><br><br><br>

                        </p>

                        <?php
                        echo '<a href="/seminar/ser/id/' . $para2 . '"><input type="button" name="next" value="次へ" /></a>';
                    }
                    ?>

                    <!--
                    
                                    <a href="/seminar/ser/<?php print @$_SESSION['para1'] . '/' . @$_SESSION['para2'] . '/' . @$_SESSION['para3']; ?>" data-role="button" data-inline="true" data-rel="back" data-theme="a">戻る</a>
                    
                    -->



                    <?php
                    if ($formon) {
                        ?>



                        <!--
                        
                                <br/>
                        
                        -->

                        <form action="/seminar/ser/book" method="post" id="form_yoyaku" data-ajax="false" onsubmit="return(fncyoyaku());">



                            <span style="color:red;font-weight:bold;">●</span>印の項目は必ずご入力ください。



                            <input type="hidden" name="セミナー番号" id="seminarno" value="<?php print $para2; ?>" />

                            <?php
                            //set letter for booking

                            if ($_SESSION['para1'] == 'kouen')
                                $letter = 'R';

                            elseif ($_SESSION['para2'] == 'event')
                                $letter = 'W';
                            else
                                $letter = 'S';
                            ?>



                            <input type="hidden" name="セミナー名" id="seminarname" value="<?php print '[' . $place . $letter . ']' . $start . ' ' . $title; ?>" />



                            <div data-role="fieldcontain">

                                <?php
                                if (@$_SESSION['mem_id'] != '') {

                                    $ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);

                                    $db = new PDO($ini['dsn'], $ini['user'], $ini['password']);

                                    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                                    $db->query('SET CHARACTER SET utf8');

                                    $stt = $db->prepare('SELECT id, email, namae, furigana, tel, country FROM memlist WHERE id = :id ');

                                    $stt->bindValue(':id', $_SESSION['mem_id']);

                                    $stt->execute();

                                    $member_info = $stt->fetch();

                                    echo '<input type="hidden" name="お名前" id="namae" value="' . $member_info['namae'] . '" size=20>';

                                    echo '<input type="hidden" name="フリガナ" id="furigana" value="' . $member_info['furigana'] . '" size=20>';

                                    echo '<input type="hidden" name="メール" id="email" value="' . $member_info['email'] . '" size=40>';

                                    echo '<input type="hidden" name="電話番号" id="tel" value="' . $member_info['tel'] . '" size=20>';
                                    ?>

                                    <fieldset data-role="controlgroup">

                                        <legend>お名前</legend>

                                        <?php echo $member_info['namae']; ?>　様

                                    </fieldset>

                                    <?php
                                } else {
                                    ?>

                                    <fieldset data-role="controlgroup">

                                        <legend><span style="color:red;font-weight:bold;">●</span>お名前</legend>

                                        <input type="text" name="お名前" id="namae" value="<?php echo @$_SESSION['yoyaku']['edit_namae'] ?>" />

                                    </fieldset>

                                    <fieldset data-role="controlgroup">

                                        <legend><span style="color:red;font-weight:bold;">●</span>フリガナ</legend>

                                        <input type="text" name="フリガナ" id="furigana" value="<?php echo @$_SESSION['yoyaku']['edit_furigana'] ?>" />

                                    </fieldset>

                                    <fieldset data-role="controlgroup">

                                        <legend><span style="color:red;font-weight:bold;">●</span>メールアドレス</legend>

                                        <input type="email" name="メール" id="email" value="<?php echo @$_SESSION['yoyaku']['edit_email'] ?>" /><br/>

                                        ※予約確認のメールをお送りします。必ず有効なアドレスを入力してください。

                                    </fieldset>

                                    <fieldset data-role="controlgroup">

                                        <legend><span style="color:red;font-weight:bold;">●</span>当日連絡の付く電話番号</legend>

                                        <input type="tel" name="電話番号" id="tel" value="<?php echo @$_SESSION['yoyaku']['edit_tel'] ?>" />

                                    </fieldset>

                                    <?php
                                }
                                ?>

                                <fieldset data-role="controlgroup">

                                    <legend>興味のある国</legend>

                                    <select name="興味国[]" multiple="multiple" data-native-menu="false" data-mini="true">

                                        <option value="アメリカ">アメリカ</option><option value="オーストラリア">オーストラリア</option><option value="ニュージーランド">ニュージーランド</option><option value="カナダ">カナダ</option><option value="韓国">韓国</option><option value="フランス">フランス</option><option value="ドイツ">ドイツ</option><option value="イギリス">イギリス</option><option value="アイルランド">アイルランド</option><option value="デンマーク">デンマーク</option><option value="ノルウェー">ノルウェー</option><option value="台湾">台湾</option><option value="香港">香港</option><option value="未定">未定</option>

                                    </select>

                                </fieldset>

                                <fieldset data-role="controlgroup">

                                    <legend>出発予定時期</legend>

                                    <select name="出発時期">

                                        <option value="">選択してください</option>

                                        <option value="3ヶ月以内">3ヶ月以内</option><option value="6ヶ月以内">6ヶ月以内</option><option value="1年以内">1年以内</option><option value="2年以内">2年以内</option><option value="未定">未定</option>

                                    </select>

                                </fieldset>

                                <fieldset data-role="controlgroup">

                                    <legend>同伴者有無</legend>

                                    <input type="checkbox" name="同伴者" id="dohan" class="custom" />

                                    <label for="dohan">同伴者あり</label>

                                    ※同伴者ありの場合、２人分の席を確保致します。<br/>

                                    ※３名以上でご参加の場合は、メールにてご連絡ください。

                                </fieldset>

                                <fieldset data-role="controlgroup">

                                    <legend>今後のご案内</legend>

                                    <input type="checkbox" name="メール会員" id="mailkaiin" class="custom" checked />

                                    <label for="mailkaiin">このメールアドレスをメール会員（無料）に登録する</label>

                                </fieldset>

                                <fieldset data-role="controlgroup">

                                    <legend>その他</legend>

                                    <input type="text" name="その他" id="sonota" value="<?php echo @$_SESSION['yoyaku']['edit_sonota'] ?>" />

                                </fieldset>

                            </div>



                            <h3>セミナーのご予約に際し、以下の内容をご確認ください。</h3>

                            <table>

                                <tr><td style="vertical-align:top;"><img src="/seminar/images/b-001.gif"></td><td>このフォームでは、仮予約の受付を行います。<br/>予約確認のメールをお送りしますので、メールの指示に従って予約を確定してください。<br/>ご予約が確定されない場合、２４時間で仮予約は自動的にキャンセルされセミナーにご参加頂けません。ご注意ください。</td></tr>

                                <tr><td style="vertical-align:top;"><img src="/seminar/images/b-002.gif"></td><td>携帯のメールアドレスをご使用の場合、info@jawhm.or.jp からのメール（ＰＣメール）が受信できるできる状態にしておいてください。</td></tr>

                                <tr><td style="vertical-align:top;"><img src="/seminar/images/b-003.gif"></td><td>Ｈｏｔｍａｉｌ、Ｙａｈｏｏメールなどをご利用の場合、予約確認のメールが遅れて到着する場合があります。時間をおいてから受信確認を行うようにしてください。</td></tr>

                                <tr><td style="vertical-align:top;"><img src="/seminar/images/b-004.gif"></td><td>予約確認メールが届かない場合、toiawase@jawhm.or.jp までご連絡ください。<br/>なお、迷惑フォルダ等に分類される場合もありますので、併せてご確認ください。</td></tr>

                            </table>


                            <input type="submit" data-role="none" data-rel="back" id="yoyakubtn" class="btn-form-reserve" value="予約する(無料)">



                        </form>





                    <?php } ?>



                    <br/>
                    <!--
                                    <a href="/seminar/ser/<?php print @$_SESSION['para1'] . '/' . @$_SESSION['para2'] . '/' . @$_SESSION['para3']; ?>" data-role="button" data-inline="true" data-rel="back" data-theme="a">戻る</a>
                    -->
                    <br/>

                </div>

                <?php print $c_footer; ?>

            </div>





            <?php
        } else {



            if ($para1 == 'ana') {

                // 情報ページ表示

                switch ($para2) {

                    case 'first':

                        break;

                    case 'wh':

                        break;

                    case 'mem':

                        break;
                }
            } elseif ($para1 == 'douji') {
                ?>

                <div data-role="page" id="doujipage" class="jquery">

                    <?php
                    print display_header('セミナー予約フォーム（同時開催）');
                    ?>

                    <p id="topicpath">

                        <a href="<?php echo $url_top; ?>" data-ajax="false">ワーキング・ホリデー協会</a>&nbsp;&gt;&nbsp;<a href="<?php print $url_home; ?>" data-inline="true">無料セミナーを探そう</a>&nbsp;&gt;&nbsp;同時開催

                    </p>

                    <div data-role="content">

                        <h2 class="title-city">セミナー会場を選択してください</h2>



                        <div style="margin: 0; padding: 5px; font-size:11pt;">

                            <p class="text01" style="text-align: center;">

                                このセミナーは複数の会場で開催されます。<br>

                                どの会場で予約しますか？<br><br>

                                <a href="javascript:void(0);" class="douji_yoyaku" data-ajax="false">ご予約はこちらから</a>

                                <br>

                            </p>

                        </div>

                        <div style="border: 1px dotted navy; margin: 0; padding: 5px; font-size:10pt;">

                            <table style="text-align: left;">

                                <tr>

                                    <th style="font-weight: normal;">開催日時　　</th>

                                    <td style="font-weight: bold;"><?php echo $douji_list[0]['start'] . '〜 '; ?></td>

                                </tr>

                                <tr>

                                    <th style="font-weight: normal;" width="80px">セミナー名　</th>

                                    <td style="font-weight: bold;"><?php echo $douji_list[0]['k_title1']; ?></td>

                                </tr>

                            </table>

                        </div>

                        <script type="text/javascript">

                            $(document).ready(function () {

                                //$('.douji_yoyaku').live('click', function() {

                                //	$.mobile.silentScroll(10000);

                                //});



                                $('a.douji_yoyaku').live('click', function (e) {

                                    e.preventDefault();

                                    var y = $("#douji_yoyaku").offset().top;

                                    $.mobile.silentScroll(y);

                                });

                            });

                        </script>

                        <div style="border: 1px dotted navy; margin-top: 10px; padding: 5px; font-size:10pt;">

                            <?php
                            $c_desc = strip_tags($douji_list[0]['k_desc1'], '<font><b><table><tr><td><img>');

                            echo nl2br($c_desc);
                            ?>

                            <br><br><br>

                        </div>

                        <a name="#douji_yoyaku" id="douji_yoyaku"></a>

                        <?php
                        foreach ($douji_list as $one) :

                            $one['place_name'] = translate_city($one['place']);

                            echo '<a href="/seminar/ser/id/' . $one['id'] . '"><input type="button" name="' . $one['place'] . '" value="' . $one['place_name'] . '会場で予約する" /></a>';

                        endforeach;
                        ?>

                    </div>

                    <?php print $c_footer; ?>

                </div>

                <?php
            }

            elseif ($para1 == 'login') {
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

                    <p id="topicpath">

                        <?php
                        if ($para1 == 'kouen') {
                            ?>

                            <a href="<?php echo $url_top; ?>" data-ajax="false">ワーキング・ホリデー協会</a>&nbsp;&gt;&nbsp;<a href="/kouenseminar.php" data-ajax="false" data-inline="true">留学・ワーホリ講演セミナー</a>&nbsp;&gt;&nbsp;会場選択

                            <?php
                        } else {
                            ?>

                            <a href="<?php echo $url_top; ?>" data-ajax="false">ワーキング・ホリデー協会</a>&nbsp;&gt;&nbsp;<a href="<?php print $url_home; ?>" data-inline="true">無料セミナーを探そう</a>&nbsp;&gt;&nbsp;会場選択

                        <?php }
                        ?>

                    </p>



                    <div data-role="content">

                        <?php
                        if ($para1 == 'place')
                            $para3 = $para2;

                        elseif ($para1 != 'kouen') {
                            ?>



                            <div class="locallist">

                                <p>会場選択</p>

                                <select name="select-choice-city" id="select-choice-city" class="select-choice"  data-native-menu="true" data-theme="a">

                                    <optgroup label="会場選択">

                                        <option value="/seminar/ser/<?php print $para1 . '/' . $para2 . '/tokyo/' . $para4; ?>" <?php
                                        if ($para3 == 'tokyo') {
                                            print ' selected';
                                        }
                                        ?>>東京</option>

                                        <option value="/seminar/ser/<?php print $para1 . '/' . $para2 . '/osaka/' . $para4; ?>" <?php
                                        if ($para3 == 'osaka') {
                                            print ' selected';
                                        }
                                        ?>>大阪</option>

                                                <!--                           <option value="/seminar/ser/<?php print $para1 . '/' . $para2 . '/sendai/' . $para4; ?>" <?php
                                        if ($para3 == 'sendai') {
                                            print ' selected';
                                        }
                                        ?>>仙台</option>	-->

                                                <!--                           <option value="/seminar/ser/<?php print $para1 . '/' . $para2 . '/toyama/' . $para4; ?>" <?php
                                        if ($para3 == 'toyama') {
                                            print ' selected';
                                        }
                                        ?>>富山</option>	-->

                                        <option value="/seminar/ser/<?php print $para1 . '/' . $para2 . '/fukuoka/' . $para4; ?>" <?php
                                        if ($para3 == 'fukuoka') {
                                            print ' selected';
                                        }
                                        ?>>福岡</option>

                                        <option value="/seminar/ser/<?php print $para1 . '/' . $para2 . '/nagoya/' . $para4; ?>" <?php
                                        if ($para3 == 'nagoya') {
                                            print ' selected';
                                        }
                                        ?>>名古屋</option>

                                        <option value="/seminar/ser/<?php print $para1 . '/' . $para2 . '/okinawa/' . $para4; ?>" <?php
                                        if ($para3 == 'okinawa') {
                                            print ' selected';
                                        }
                                        ?>>沖縄</option>

                                        <option value="/seminar/ser/<?php print $para1 . '/' . $para2 . '/event/' . $para4; ?>" <?php
                                        if ($para3 == 'event') {
                                            print ' selected';
                                        }
                                        ?>>その他の会場</option>

                                    </optgroup>

                                </select>

                            </div>

                            <?php
                            if ($para3 == '')
                                $para3 = 'tokyo';



                            if ($para1 == 'know') {

                                $array_icon_available = array('all', 'aus', 'can', 'nz', 'uk', 'fra', 'other');



                                if (in_array($para4, $array_icon_available))
                                    $display_title = ' select-country-' . $para4;
                                else
                                    $display_title = '';
                                ?>

                                <div class="locallist<?php echo $display_title; ?>">

                                    <p>興味のある国選択</p>

                                    <select name="select-choice-country" id="select-choice-country" class="select-choice" data-native-menu="true" data-theme="a">

                                        <optgroup label="興味のある国選択">

                                            <option value="/seminar/ser/<?php print $para1 . '/' . $para2 . '/' . $para3; ?>/all" <?php
                                            if ($para4 == 'all') {
                                                print ' selected';
                                            }
                                            ?>>全て</option>

                                            <option value="/seminar/ser/<?php print $para1 . '/' . $para2 . '/' . $para3; ?>/aus" <?php
                                            if ($para4 == 'aus') {
                                                print ' selected';
                                            }
                                            ?>>オーストラリア</option>

                                            <option value="/seminar/ser/<?php print $para1 . '/' . $para2 . '/' . $para3; ?>/can" <?php
                                            if ($para4 == 'can') {
                                                print ' selected';
                                            }
                                            ?>>カナダ</option>

                                            <option value="/seminar/ser/<?php print $para1 . '/' . $para2 . '/' . $para3; ?>/nz" <?php
                                            if ($para4 == 'nz') {
                                                print ' selected';
                                            }
                                            ?>>ニュージーランド</option>

                                            <option value="/seminar/ser/<?php print $para1 . '/' . $para2 . '/' . $para3; ?>/uk" <?php
                                            if ($para4 == 'uk') {
                                                print ' selected';
                                            }
                                            ?>>イギリス</option>

                                            <option value="/seminar/ser/<?php print $para1 . '/' . $para2 . '/' . $para3; ?>/fra" <?php
                                            if ($para4 == 'fra') {
                                                print ' selected';
                                            }
                                            ?>>フランス</option>

                                            <option value="/seminar/ser/<?php print $para1 . '/' . $para2 . '/' . $para3; ?>/usa" <?php
                                            if ($para4 == 'usa') {
                                                print ' selected';
                                            }
                                            ?>>アメリカ</option>

                                            <option value="/seminar/ser/<?php print $para1 . '/' . $para2 . '/' . $para3; ?>/other" <?php
                                            if ($para4 == 'other') {
                                                print ' selected';
                                            }
                                            ?>>その他</option>

                                        </optgroup>

                                    </select>

                                </div>

                                <?php
                            } elseif ($para1 == 'country') {

                                $array_icon_available = array('all', 'first', 'school', 'kouen', 'student', 'foot', 'abili', 'plan');



                                if (in_array($para4, $array_icon_available))
                                    $display_title = ' select-' . $para4;
                                else
                                    $display_title = '';
                                ?>

                                <div class="locallist<?php echo $display_title; ?>">

                                    <p>セミナーの内容選択</p>

                                    <select name="select-choice-know" id="select-choice-know" class="select-choice" data-native-menu="true" data-theme="a">

                                        <optgroup label="セミナーの内容選択">

                                            <option value="/seminar/ser/<?php print $para1 . '/' . $para2 . '/' . $para3; ?>/all" <?php
                                            if ($para4 == 'all') {
                                                print ' selected';
                                            }
                                            ?>>全て</option>

                                            <option value="/seminar/ser/<?php print $para1 . '/' . $para2 . '/' . $para3; ?>/first" <?php
                                            if ($para4 == 'first') {
                                                print ' selected';
                                            }
                                            ?>>初心者向け</option>

                                            <option value="/seminar/ser/<?php print $para1 . '/' . $para2 . '/' . $para3; ?>/plan" <?php
                                            if ($para4 == 'plan') {
                                                print ' selected';
                                            }
                                            ?>>プランニング法セミナー</option>

                                            <option value="/seminar/ser/<?php print $para1 . '/' . $para2 . '/' . $para3; ?>/student" <?php
                                            if ($para4 == 'student') {
                                                print ' selected';
                                            }
                                            ?>>情報収集セミナー</option>

                                            <option value="/seminar/ser/<?php print $para1 . '/' . $para2 . '/' . $para3; ?>/foot" <?php
                                            if ($para4 == 'foot') {
                                                print ' selected';
                                            }
                                            ?>>人数限定！懇談セミナー</option>

                                            <option value="/seminar/ser/<?php print $para1 . '/' . $para2 . '/' . $para3; ?>/kouen" <?php
                                            if ($para4 == 'kouen') {
                                                print ' selected';
                                            }
                                            ?>>体験談セミナー</option>

                                            <option value="/seminar/ser/<?php print $para1 . '/' . $para2 . '/' . $para3; ?>/school" <?php
                                            if ($para4 == 'school') {
                                                print ' selected';
                                            }
                                            ?>>語学学校セミナー</option>

                                            <option value="/seminar/ser/<?php print $para1 . '/' . $para2 . '/' . $para3; ?>/abili" <?php
                                            if ($para4 == 'abili') {
                                                print ' selected';
                                            }
                                            ?>>注目！！人気のセミナー</option>

                                        </optgroup>

                                    </select>

                                </div>

                                <?php
                            }



                            if (($para1 == 'know' && $para4 == '') || ($para1 == 'country' && $para4 == ''))
                                $para4 = 'all';
                        }
                        ?>



                        <div class="smlBanner" style="margin-bottom:8px;">

                            <?php echo $ser_banner[$para3]; ?>

                        </div>



                        <?php
                        switch ($para1 . $para2) {

                            case 'pagemember':

                                print '<h2 id="p-member">メンバー限定セミナーを予約する</h2>';

                                break;

                            case 'countryaus':

                                print '<h2 class="title-country" id="c-aus">オーストラリアのセミナー</h2>';

                                break;

                            case 'countrynz':

                                print '<h2 class="title-country" id="c-nz">ニュージーランドのセミナー</h2>';

                                break;

                            case 'countrycan':

                                print '<h2 class="title-country" id="c-can">カナダのセミナー</h2>';

                                break;

                            case 'countryuk':

                                print '<h2 class="title-country" id="c-uk">イギリスのセミナー</h2>';

                                break;

                            case 'countryfra':

                                print '<h2 class="title-country" id="c-fra">フランスのセミナー</h2>';

                                break;

                            case 'countryusa':

                                print '<h2 class="title-country" id="c-usa">アメリカのセミナー</h2>';

                                break;

                            case 'countryother':

                                print '<h2 class="title-country" id="c-other">その他の国のセミナー</h2>';

                                break;

                            case 'countryall':

                                print '<h2 class="title-country" id="c-all">全て国のセミナー</h2>';

                                break;

                            case 'knowfirst':

                                print '<h2 class="title-know" id="k-first">初心者セミナー</h2>';

                                print '<p>初めてセミナーにご参加される場合にお勧めのセミナーです。</p>';

                                break;

                            case 'knowfoot':

                                print '<h2 class="title-know" id="k-foot">人数限定！懇談セミナー</h2>';

                                print '<p>人数限定！少人数で何でも質問できるセミナーです。</p>';

                                break;

                            case 'knowstudent':

                                print '<h2 class="title-know" id="k-student">情報収集セミナー</h2>';

                                print '<p>国比較や現地の詳しい情報など、もっともっと深いセミナーです。</p>';

                                break;

                            case 'knowschool':

                                print '<h2 class="title-know" id="k-school">語学学校セミナー</h2>';

                                print '<p>語学学校の必要性や、様々な特徴のある語学学校を紹介するセミナーです。</p>';

                                break;

                            case 'knowabili':

                                print '<h2 class="title-know" id="k-abili">注目！！人気のセミナー</h2>';

                                print '<p>注目・人気のセミナーを集めました。満席になるまでに予約しよう！！</p>';

                                break;

                            case 'knowkouen':

                                print '<h2 class="title-know" id="k-kouen">体験談セミナー</h2>';

                                print '<p>ワーホリ＆留学体験者の声が聴ける貴重なセミナーです。</p>';

                                break;

                            case 'knowplan':

                                print '<h2 class="title-know" id="k-kouen">プランニング法セミナー</h2>';

                                print '<p>ワーホリ＆留学のプランを検討する為のセミナーです。</p>';

                                break;

                            case 'knowall':

                                print '<h2 class="title-know" id="k-all">全て</h2>';

                                print '<p>全て、内容からセミナーを探す</p>';

                                break;

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





                        <?php
                        // イベント読み込み

                        $cal = array();



                        try {

                            $ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);

                            $db = new PDO($ini['dsn'], $ini['user'], $ini['password']);

                            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                            $db->query('SET CHARACTER SET utf8');

//		$rs = $db->query('SELECT id, year(hiduke) as yy, month(hiduke) as mm, day(hiduke) as dd, title, memo, place, k_use, k_title1, k_desc1, k_stat FROM event_list WHERE k_use = 1 AND hiduke >= "'.date("Y/m/d",strtotime("-1 week")).'"  ORDER BY hiduke, id');
                            // パラメータ確認

                            $where_place = '';





                            //Keyword Where_country Where_know
                            //-------------------------------

                            $where_country = ' ( 1=0';

                            $where_know = ' ( 1=0';



                            if ($para1 == 'country') {

                                $where_country .= where_country($para2);

                                $where_know .= where_know($para4);
                            } elseif ($para1 == 'know') {

                                $where_country .= where_country($para4);

                                $where_know .= where_know($para2);
                            }



                            $where_country .= ' ) ';

                            $where_know .= ' ) ';



                            $stt = $db->prepare('SELECT * FROM place WHERE area = :place ');

                            $stt->bindValue(':place', $para3);

                            $stt->execute();

                            $place_list = array();

                            while ($row = $stt->fetch(PDO::FETCH_ASSOC)) {

                                $place_list[] = $row;
                            }

                            if (empty($place_list) or $use_area == false) {

                                $stt = $db->prepare('SELECT * FROM place WHERE place = :place ');

                                $stt->bindValue(':place', $para3);

                                $stt->execute();

                                $place_info = $stt->fetch();

                                $searchplus = "";

                                if (!empty($place_info['searchplus'])) {

                                    $searchplus = ' or  k_title1 like \'%' . $place_info['name'] . '%\'';
                                }

                                $where_place = '(place = \'' . $para3 . '\' or k_desc2 like \'%' . $para3 . '%\' ' . $searchplus . ' ) ';
                            } else {

                                $wheres = array();

                                foreach ($place_list as $info) {

                                    $searchplus = "";

                                    if (!empty($info['searchplus'])) {

                                        $searchplus = ' or  k_title1 like \'%' . $info['name'] . '%\'';
                                    }

                                    $wheres[] = '(place = \'' . $info['place'] . '\' or k_desc2 like \'%' . $info['place'] . '%\' ' . $searchplus . ' ) ';
                                }

                                $where_place = '( ' . implode(" or ", $wheres) . ' )';
                            }

                            /*

                              if ($para3 == 'fukuoka')

                              $where_place = ' ( place = \''.$para3.'\' or k_title1 like \'%福岡%\' ) ';

                              else

                              $where_place = ' ( place = \''.$para3.'\' ) ';

                             */

                            $keyword = '';



                            if ($where_place <> '')
                                $keyword .= ' and ' . $where_place;



                            if ($where_country != ' ( 1=0 ) ')
                                $keyword .= ' and ' . $where_country;



                            if ($where_know <> ' ( 1=0 ) ')
                                $keyword .= ' and ' . $where_know;



                            //---------------------------------
                            //Selected day from calendar module
                            //---------------------------------
                            if ($_SESSION['para1'] == 'place' && !empty($_SESSION['para6'])) {

                                $rs_selected = $db->query('SELECT id, hiduke, year(hiduke) as yy, month(hiduke) as mm, day(hiduke) as dd, date_format(starttime, \'%c月%e日 (%a) %k:%i\') as start, date_format(starttime, \'%k:%i\') as starttime, title, memo, place, k_use, k_title1, k_desc1, k_desc2, k_stat, free, pax, booking, group_color, indicated_option, broadcasting, country_code FROM event_list WHERE id=\'' . $_SESSION['para6'] . '\'');



                                $row_selected = $rs_selected->fetch(PDO::FETCH_ASSOC);



                                $year = $row_selected['yy'];

                                $month = $row_selected['mm'];

                                $day = $row_selected['dd'];



                                $start = $row_selected['start'] . '～';

                                $start = mb_ereg_replace('Mon', '月', $start);

                                $start = mb_ereg_replace('Tue', '火', $start);

                                $start = mb_ereg_replace('Wed', '水', $start);

                                $start = mb_ereg_replace('Thu', '木', $start);

                                $start = mb_ereg_replace('Fri', '金', $start);

                                $start = mb_ereg_replace('Sat', '土', $start);

                                $start = mb_ereg_replace('Sun', '日', $start);



                                $title = $start . ' ' . $row_selected['k_title1'];



                                $japanese_city_name = "";

                                if ($row_selected['place'] == 'event') {

                                    $japanese_city_name = translate_city($row_selected['k_desc2']);

                                    if (empty($japanese_city_name)) {

                                        $japanese_city_name = translate_city($row_selected['place']);
                                    }
                                } else {

                                    $japanese_city_name = translate_city($row_selected['place']);
                                }



                                $c_desc = strip_tags($row_selected['k_desc1'], '<font><b><table><tr><td><img>');



                                if ($row['k_stat'] == 1) {

                                    if ($row_selected['booking'] >= $row_selected['pax'])
                                        $c_img = '[満席です]';
                                    else
                                        $c_img = '[残席わずかです。ご予約はお早めに]';
                                }

                                elseif ($row_selected['k_stat'] == 2)
                                    $c_img = '[満席です]';

                                else {

                                    if ($row_selected['booking'] >= $row_selected['pax'])
                                        $c_img = '[満席です]';

                                    else {

                                        if ($row_selected['booking'] >= $row_selected['pax'] / 3)
                                            $c_img = '[残席わずかです。ご予約はお早めに]';
                                        else
                                            $c_img = '';
                                    }
                                }



                                if ($c_img <> '')
                                    $c_img = '<h3 class="last-seat">' . $c_img . '</h3>';



                                //check flag

                                if (!empty($row_selected['country_code']))
                                    $flag = '<span class="flag ' . $row_selected['country_code'] . '"></span>';
                                else
                                    $flag = '';



                                //Check if live or not

                                if ($row_selected['broadcasting'] != 0)
                                    $icon_live = '<span class="broadcast"></span>';
                                else
                                    $icon_live = '';



                                //Check the option statut

                                switch ($row_selected['indicated_option']) {

                                    case 0:

                                        $indication = '';

                                        break;

                                    case 1:

                                        $indication = '<span class="osusume"></span>';

                                        break;

                                    case 2:

                                        $indication = '<span class="shinchyaku"></span>';

                                        break;
                                }



                                //get color groupe or set gray if empty

                                if ($row_selected['group_color'] == '')
                                    $color_group = '#999';
                                else
                                    $color_group = $row_selected['group_color'];



                                $yobi = array('日', '月', '火', '水', '木', '金', '土');

                                $print_selected = mktime(0, 0, 0, $_SESSION['para4'], $_SESSION['para5'], $_SESSION['para3']);



                                // message to display

                                $c_msg = '<h3 class="title-date selected-title-date">' . $flag . date('n月j日 (' . $yobi[date('w', $print_selected)] . ')', $print_selected) . '&nbsp;&nbsp;' . $icon_live . $indication . '</h3>';

                                $c_msg .= '<div id="' . $row_selected['id'] . '-0" class="message_box">';

                                if ($row_selected['hiduke'] < date('Y-m-d')) {

                                    $c_msg .= '<div class="">';
                                } else {

                                    $c_msg .= '<div onclick="window.open(\'/seminar/ser/id/' . $row_selected['id'] . '\',\'_self\')" alt="' . $row_selected['hiduke'] . '" class="message_link selected_day">';
                                }

                                $c_msg .= $c_img;

                                $c_msg .= '<h3 class="time-place-seminar" style="border-color:' . $color_group . ';">' . $flag . $row_selected['starttime'] . '～　' . $japanese_city_name . '会場&nbsp;' . $icon_live . $indication . '</h3>';

                                $c_msg .= '<h3 style="border-color:' . $color_group . ';" class="title-seminar">' . $row_selected['k_title1'] . '</h3>';

                                $c_msg .= '<div class="detail">' . nl2br($c_desc) . '';

                                $c_msg .= '<br/>';

                                if ($row_selected['hiduke'] < date('Y-m-d')) {

                                    $c_msg .= '<br/>[[ このセミナーは終了しました。 ]]<br/>';

                                    $c_msg .= 'ワーホリ・留学に役立つセミナーを日本ワーキングホリデー協会では毎日開催しております。<br/>';

                                    $c_msg .= '皆様のご参加をお待ちしております。<a href="/seminar/seminar" alt="ワーホリセミナー" rel="external">別のセミナーを探す</a><br/>';
                                } else {

                                    $c_msg .= '<button value="ご予約はこちら" / >';
                                }

                                $c_msg .= '<br/>';

                                $c_msg .= '<br/></div>';

                                $c_msg .= '</div></div>';



                                //$cal_msg_selected[$year.$month.$day] = $c_msg;
                                $selected_event = $c_msg;
                            }



                            //---------------------------
                            //first 5 seminar to display
                            //---------------------------

                            $just_one = false; //only one seminar

                            $free = 0; //set for free seminar



                            $query = 'SELECT id, hiduke, year(hiduke) as yy, month(hiduke) as mm, day(hiduke) as dd, date_format(starttime, \'%c月%e日 (%a) %k:%i\') as start, date_format(starttime, \'%k:%i\') as starttime, title, memo, place, k_use, k_title1, k_desc1, k_desc2, k_stat, free, pax, booking, group_color, indicated_option, broadcasting, country_code FROM event_list WHERE k_use = 1 AND ';



                            if ($para1 == 'kouen') /*                             * ** Kouenseminar *** */ {

                                $query .='k_desc2 like \'%' . $para2 . '%\' ORDER BY hiduke, starttime, id';
                            } elseif ($para1 == 'place' && $para2 == 'event' && !empty($para6)) {  //if we get num/id for event we only choose one seminar
                                $just_one = true;

                                $query .='id = \'' . $para6 . '\'';
                            } elseif ($para2 == 'member') {

                                $query .='free = 1 AND hiduke >= DATE_SUB(CURDATE(),INTERVAL 0 DAY) ' . $keyword . ' ORDER BY hiduke, starttime, id  LIMIT 0,' . DEFAULT_SEMINAR_COUNT;

                                $free = 1;
                            } else {

                                // $query .='free = 0 AND hiduke >= DATE_SUB(CURDATE(),INTERVAL 0 DAY) '.$keyword.' ORDER BY hiduke, starttime, id  LIMIT 0,15';
                                //満席を含めたセミナーを取得
                                $query .=' hiduke >= DATE_SUB(CURDATE(),INTERVAL 0 DAY) ' . $keyword . ' ORDER BY hiduke, starttime, id  LIMIT 0,' . DEFAULT_SEMINAR_COUNT;
                            }



                            $rs = $db->query($query);



                            $cnt = 0;



                            while ($row = $rs->fetch(PDO::FETCH_ASSOC)) {

                                $cnt++;

                                $year = $row['yy'];

                                $month = $row['mm'];

                                $day = $row['dd'];



                                $start = $row['start'] . '～';

                                $start = mb_ereg_replace('Mon', '月', $start);

                                $start = mb_ereg_replace('Tue', '火', $start);

                                $start = mb_ereg_replace('Wed', '水', $start);

                                $start = mb_ereg_replace('Thu', '木', $start);

                                $start = mb_ereg_replace('Fri', '金', $start);

                                $start = mb_ereg_replace('Sat', '土', $start);

                                $start = mb_ereg_replace('Sun', '日', $start);



                                $title = $start . ' ' . $row['k_title1'];



                                $japanese_city_name = "";

                                if ($row['place'] == 'event') {

                                    $japanese_city_name = translate_city($row['k_desc2']);

                                    if (empty($japanese_city_name)) {

                                        $japanese_city_name = translate_city($row['place']);
                                    }
                                } else {

                                    $japanese_city_name = translate_city($row['place']);
                                }



                                $c_desc = strip_tags($row['k_desc1'], '<font><b><table><tr><td><img>');



                                if ($row['k_stat'] == 1) {

                                    if ($row['booking'] >= $row['pax'])
                                        $c_img = '[満席です]';
                                    else
                                        $c_img = '[残席わずかです。ご予約はお早めに]';
                                }

                                elseif ($row['k_stat'] == 2)
                                    $c_img = '[満席です]';

                                else {

                                    if ($row['booking'] >= $row['pax'])
                                        $c_img = '[満席です]';

                                    else {

                                        if ($row['booking'] >= $row['pax'] / 3)
                                            $c_img = '[残席わずかです。ご予約はお早めに]';
                                        else
                                            $c_img = '';
                                    }
                                }

                                if ($c_img <> '')
                                    $c_img = '<p class="last-seat">' . $c_img . '</p>';



                                //check flag

                                if (!empty($row['country_code']))
                                    $flag = '<span class="flag ' . $row['country_code'] . '"></span>';
                                else
                                    $flag = '';



                                //Check if live or not

                                if ($row['broadcasting'] != 0)
                                    $icon_live = '<span class="broadcast"></span>';
                                else
                                    $icon_live = '';



                                //Check the option statut

                                switch ($row['indicated_option']) {

                                    case 0:

                                        $indication = '';

                                        break;

                                    case 1:

                                        $indication = '<span class="osusume"></span>';

                                        break;

                                    case 2:

                                        $indication = '<span class="shinchyaku"></span>';

                                        break;
                                }



                                //get color groupe or set gray if empty

                                if ($row['group_color'] == '')
                                    $color_group = '#999';
                                else
                                    $color_group = $row['group_color'];



                                //Set the selected day class only for 'Place'

                                if ($_SESSION['para1'] == 'place' && !empty($_SESSION['para6']) && $just_one === false) {

                                    if ($row['id'] == $_SESSION['para6'])
                                        $class_selected_day = ' selected_day';
                                    else
                                        $class_selected_day = '';
                                } else
                                    $class_selected_day = '';



                                // message to display
                                $hidden_block = "not-full";
                                if (preg_match('/満席です/i', $c_img)) {
                                    $hidden_block = "full-seminar";
                                }
                                $cal[$year . $month . $day] .= '<img src="images/sa01.jpg">';

                                $c_msg = '<div id="' . $row['id'] . '-' . $cnt . '" class="message_box ' . $hidden_block . '" data-role="collapsible" style="background-color:white;">';

                                $c_msg .= '<h3 class="time-place-seminar" style="border:0px;">' . $c_img;

                                $c_msg .= $flag . $row['starttime'] . '～　' . $japanese_city_name . '会場&nbsp;' . $icon_live . $indication . '<br/>';

                                $c_msg .= $row['k_title1'] . '</h3>';



                                $add_area = '';

                                if ($use_area && $row['place'] != $para3) {

                                    $add_area = '/area';
                                }



                                if ($row['free'] && $_SESSION['mem_id'] == '') {

                                    $c_msg .= '<div onclick="window.open(\'/seminar/ser/login/' . $row['id'] . '\',\'_self\')" alt="' . $row['hiduke'] . '" class="message_link' . $class_selected_day . '">';

                                    $c_msg .= '<div class="detail">' . nl2br($c_desc) . '';

                                    $c_msg .= '<br/><br/><p style="font-weight: bold;">※このセミナーは、メンバー限定セミナーです。ログインして下さい。</p><br/>';

                                    $c_msg .= '<br/><button value="ログイン">ログイン</button><br/>';
                                } else {

                                    $c_msg .= '<div onclick="window.open(\'/seminar/ser/id/' . $row['id'] . $add_area . '\',\'_self\')" alt="' . $row['hiduke'] . '" class="message_link' . $class_selected_day . '">';

                                    $c_msg .= '<div class="detail">' . nl2br($c_desc) . '';

                                    $c_msg .= '<br/><button value="ご予約はこちら">ご予約はこちら</button><br/>';
                                }



                                $c_msg .= '<br/></div>';

                                $c_msg .= '</div></div>';

                                $cal_msg[$year . $month . $day] .= $c_msg;

                                if ($just_one === false) {

                                    $cal_cnt[$year . $month . $day] = count_number_of_seminar($keyword, $row['hiduke'], $free);

                                    $cal_iconlist[$year . $month . $day] = icon_list_of_the_day($keyword, $row['hiduke'], $free);

                                    $cal_flaglist[$year . $month . $day] = flag_list_of_the_day($keyword, $row['hiduke'], $free);
                                }
                            }
                        } catch (PDOException $e) {

                            die($e->getMessage());
                        }
                        ?>



                        <?php
                        if ($cnt == 0)
                            print '<p>該当するセミナーがありません。検索条件を変更してください。</p>';
                        else {
                            
                        }
                        echo '<br/>';
                        ?>

                        <div class="legend">

                            <p><strong>【アイコンの意味】</strong><br/>

                                <span style="margin-left:20px;"><img src="/css/images/au.png" alt="Australian Flag" />&nbsp;<img src="/css/images/ca.png" alt="Canadian Flag" />&nbsp;<img src="/css/images/uk.png" alt="Union Jack" />&nbsp;&nbsp;国別セミナー</span>

                                <span style="margin-left:20px;"><img src="/css/images/wd.png" alt="World" />&nbsp;&nbsp;英語圏セミナー</span>

                                <span style="margin-left:20px;"><img src="/css/images/hoshi.png" alt="osusume" />&nbsp;&nbsp;おススメ</span>

                                <span style="margin-left:20px;"><img src="/css/images/full.png" alt="fullybooked" />&nbsp;&nbsp;満席</span>

                                <span style="margin-left:20px;"><img src="/css/images/camera.png" alt="camera" />&nbsp;&nbsp;中継対象</span><br/>

                            </p>

                        </div>
                        <?php echo $selected_event ?>
                        <div id="title-top">Loading...<img src="/seminar/bigLoader.gif" /></div>
                        <div id="fullsem_flip">
                            <span id="mes">満席セミナー表示</span>
                            <div style="width: 100px">
                                <input type="hidden" name="isFull" value="<?php ($_GET['isFull'] == 'on') ? '1' : '0'; ?>" />
                                <select name="flip-1" id="flip-1" data-role="slider">
                                    <option value="off">OFF</option>
                                    <option value="on">ON</option>
                                </select>
                            </div>
                        </div>


                        <div class="" style="clear: both;"></div>
                        <button type="button" id="moreviewbutton" onclick="last_msg_funtion_for_button()">もっと見る</button>

                        <div id="last_msg_loader"></div>



                        <p>

                            セミナーに参加されるほとんどの方が、お一人でのご参加です。<br/>

                            どうぞ、お気軽にご予約の上、ご参加ください。<br/>

                        </p>



                        <?php
                        if ($para1 == 'kouen') {
                            ?>

                            <br/>

                            <a href="/kouenseminar.php" data-role="button" data-ajax="false" data-inline="true" data-theme="a">戻る</a>

                            <br/>

                            <?php
                        } else {
                            ?>



                            <br/>

                            <!--
                            
                                        <a href="<?php print $url_home; ?>" data-role="button" data-transition="fade" data-ajax="true" data-icon="arrow-l" data-inline="true" data-theme="a">セミナーＴＯＰへ</a>
                            
                                        <br/>
                            
                            -->

                        <?php }
                        ?>

                    </div>

                    <?php print $c_footer; ?>





                </div>

                <?php
            }
        }
        ?>

    </body>
</html>

