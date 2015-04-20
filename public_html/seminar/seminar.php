<?php
//ini_set( "display_errors", "On");

	session_start();

	ini_set( "display_errors", "Off");
	mb_language("Ja");
	mb_internal_encoding("utf8");
	
	// パラメータ確認
	$d = @$_GET['d'];

	// ログイン情報
	$mem_id = @$_SESSION['mem_id'];
	$mem_name = @$_SESSION['mem_name'];
	$mem_level = @$_SESSION['mem_level'];

	// 状態確認
	if ($mem_id <> '')	
	{
		try {
			$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);
			$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$db->query('SET CHARACTER SET utf8');
			$stt = $db->prepare('SELECT id, email, namae, furigana, tel, country FROM memlist WHERE id = :id ');
			$stt->bindValue(':id', $mem_id);
			$stt->execute();
			$mem_namae = '';
			$mem_furigana = '';
			$mem_tel = '';
			$mem_email = '';
			$mem_country = '';
			while($row = $stt->fetch(PDO::FETCH_ASSOC)){
				$mem_email = $row['email'];
				$mem_namae = $row['namae'];
				$mem_furigana = $row['furigana'];
				$mem_tel = $row['tel'];
				$mem_country = $row['country'];
			}
			$db = NULL;
		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}

	function is_mobile () 
	{
		$useragents = array(
			'iPhone',         // Apple iPhone
			'iPod',           // Apple iPod touch
			'iPad',           // Apple iPad touch
			'Android',        // 1.5+ Android
			'dream',          // Pre 1.5 Android
			'CUPCAKE',        // 1.5+ Android
			'blackberry9500', // Storm
			'blackberry9530', // Storm
			'blackberry9520', // Storm v2
			'blackberry9550', // Storm v2
			'blackberry9800', // Torch
			'webOS',          // Palm Pre Experimental
			'incognito',      // Other iPhone browser
			'webmate'         // Other iPhone browser
		);
		
		$pattern = '/'.implode('|', $useragents).'/i';
		return preg_match($pattern, $_SERVER['HTTP_USER_AGENT']);
	}

include '../seminar_module/seminar_module.php';

$config = array(
	'calendar' => array(
		'use_area' => 'on',
		'country_list' => array(
			array('id' => 'all',	'active' => 'on'),
			array('id' => 'aus',	'active' => 'on'),
			array('id' => 'nz',	'active' => 'on'),
			array('id' => 'can',	'active' => 'on'),
			array('id' => 'uk',	'active' => 'on'),
			array('id' => 'fra',	'active' => 'on'),
			array(	'id' => 'usa',
				'name' => 'アメリカ',
				'word1' => array('アメリカ',),
				'active' => 'on'
			),
			array('id' => 'other',	'active' => 'on'),
		),
		'know_list' => array(
			array('id' => 'all',	'active' => 'on'),
			array('id' => 'first',	'active' => 'off'),
			array('id' => 'sanpo',	'active' => 'off'),
			array('id' => 'sc',	'active' => 'off'),
			array('id' => 'ga',	'active' => 'off'),
			array('id' => 'si',	'active' => 'off'),
			array('id' => 'kouen',	'active' => 'off'),
			array(	'id' => 's01',
				'name' => '初心者向けセミナー',
				'word2' => array('初心者'),
				'active' => 'on',
			),
			array(	'id' => 's02',
				'name' => 'プランニング法セミナー',
				'word2' => array('プランニング'),
				'active' => 'on',
			),
			array(	'id' => 's03',
				'name' => '情報取集セミナー',
				'word2' => array('学校比較','看護師','休学','住まい仕事','学習法','トラブル','資格','セカンド','学生限定','都市比較'),
				'active' => 'on',
			),
			array(	'id' => 's04',
				'name' => '少人数！懇談セミナー',
				'word2' => array('渡航相談会','女性限定','休職'),
				'active' => 'on',
			),
			array(	'id' => 's06',
				'name' => '体験談セミナー',
				'word2' => array('体験談'),
				'active' => 'on',
			),
			array(	'id' => 's05',
				'name' => '語学学校セミナー',
				'word2' => array('学校セミナー','学校懇談'),
				'active' => 'on',
			),
			array(	'id' => 's07',
				'name' => '注目！人気のセミナー',
				'word2' => array('注目','学校セミナー','学校懇談','パーティー','国比較'),
				'active' => 'on',
			),
			array(	'id' => 's08',
				'name' => 'メンバ限定セミナー',
				'word2' => array('会員限定','出発前'),
				'active' => 'on',
			),

		),
	)
);

$sm = new SeminarModule($config);
$redirection = $sm->get_mobileredirect();

require_once '../include/header.php';

$header_obj = new Header();

//$title = 'ワーホリ（ワーキングホリデー）の無料セミナー（説明会）情報';
//if (@$_GET['place_name'] == 'tokyo')	{	$title .= '【東京】';	}
//if (@$_GET['place_name'] == 'osaka')	{	$title .= '【大阪】';	}
//if (@$_GET['place_name'] == 'nagoya')	{	$title .= '【名古屋】';	}
//if (@$_GET['place_name'] == 'fukuoka')	{	$title .= '【福岡】';	}
//if (@$_GET['place_name'] == 'okinawa')	{	$title .= '【沖縄】';	}
$title = 'ワーホリ・留学の無料セミナー(説明会)';

$header_obj->title_page=$title;

$header_obj->description_page='ワーキングホリデー（ワーホリ）や留学をされる方向けの無料セミナー等のご案内をしています。ワーキングホリデー（ワーホリ）協定国の最新のビザ取得方法や渡航情報などを発信しています。オーストラリア、ニュージーランド、カナダ、韓国、フランス、ドイツ、イギリス、アイルランド、デンマーク、台湾、香港でワーキングホリデー（ワーホリ）ビザの取得が可能です。ワーキングホリデー（ワーホリ）ビザ以外に学生ビザでの留学などもお手伝い可能です。';

$header_obj->fncFacebookMeta_function= true;

$header_obj->mobileredirect=$redirection;

$header_obj->size_content_page='big';

$header_obj->add_js_files  = $sm->get_add_js();
$header_obj->add_css_files = $sm->get_add_css();
$header_obj->add_style     = $sm->get_add_style();

$header_obj->full_link_tag = true;
$header_obj->fncMenuHead_h1text = 'ワーホリ・留学の無料セミナー（説明会）情報';

/*
  // member
  define('MAX_PATH', '/var/www/html/ad');
  if (@include_once(MAX_PATH . '/www/delivery/alocal.php')) {
    if (!isset($phpAds_context)) {
      $phpAds_context = array();
    }
    // function view_local($what, $zoneid=0, $campaignid=0, $bannerid=0, $target='', $source='', $withtext='', $context='', $charset='')
    $phpAds_raw = view_local('', 144, 0, 0, '', '', '0', $phpAds_context, '');
    echo $phpAds_raw['html'];
  }
*/

$header_obj->fncMenuHead_imghtml = '<img id="top-mainimg" src="/images/mainimg/seminar-mainimg.jpg" alt="" />';


$header_obj->display_header();
?>
<script type="text/javascript" src="../js/wz_tooltip.js"></script>

        <div id="maincontent">
    
	  <?php echo $header_obj->breadcrumbs(); ?>
    
            <h2 class="sec-title">ワーホリ・留学の無料セミナーのご案内</h2>
    
            <div style="padding-left:20px; float:left; margin-bottom: 20px; width:100%;" >
		<p>ワーキングホリデーセミナーでは</p>
		<table style="margin: 10px 0 10px 20px; font-size:10pt;">
			<tr>
				<td>●　ワーキングホリデービザの取得方法</td>
				<td>&nbsp;</td>
				<td>●　ワーキングホリデービザで出来ること</td>
			</tr>
			<tr>
				<td>●　ワーキングホリデーに必要なもの</td>
				<td>&nbsp;</td>
				<td>●　各国の特徴</td>
			</tr>
			<tr>
				<td>●　ワーキングホリデーの最近の傾向</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td colspan="3">●　ワーキングホリデーに興味はあるけれど、何から始めていいのか解らない方</td>
			</tr>
		</table>
		<p>などのお話を致します。</p>
			<p>
			&nbsp;<br/>
			各セミナーには質疑応答時間もありますので、遠慮されずに積極的に質問してくださいね。<br/>
			&nbsp;<br/>
			現地でのアルバイトやシェアハウスの見つけ方等、なんでもご質問にお答え致します。<br/>
			お友達もお誘いの上、どうぞご参加ください。<br/>
			&nbsp;<br/>
			また、参加者の９割の方は、お一人でのご参加です。<br/>
			お一人でもお気軽にお越しください。<br/>
			<a href="http://www.jawhm.or.jp/qa_seminar.html" target="blank">⇒　セミナーに関するQ&Aはこちらから</a>
			&nbsp;<br/><br/>
			<a href="/mem/" target="blank"><img src="/images/seminar_member_off.png" border="0" onMouseOver="this .src='/images/seminar_member_on.png'" onMouseOut="this .src='/images/seminar_member_off.png'" art="メンバー登録"/></a>
			&nbsp;
			<a href="/seminar/seminar_01.php" target="blank"><img src="/images/seminar_seminar_off.png" border="0" onMouseOver="this .src='/images/seminar_seminar_on.png'" onMouseOut="this .src='/images/seminar_seminar_off.png'" art="初心者向けセミナー"/></a>
			&nbsp;
			<a href="/interview/" target="blank"><img src="/images/seminar_counselor_off.png" border="0" onMouseOver="this .src='/images/seminar_counselor_on.png'" onMouseOut="this .src='/images/seminar_counselor_off.png'" art="初心者向けセミナー"/></a>
			</p>

	</div>
				        
            <div class="navy-dotted" >
                セミナーには、どなたでもご参加できます。（無料です。）
            </div>




            <h2 class="sec-title">ワーホリ・留学の無料セミナーを探す</h2>
            
            <p style="margin: 0 0 8px 10px; font-size:11pt;">
            参加したいセミナーの検索条件を指定してください。 <br />
<br />
            </p>
	  <?php $sm->show(); ?>


			<center>	
			<a href="/guidebook" target="_blank">
			<img style="margin: 15px auto -10px auto;" src="/images/guidebook_off.jpg">
			</a>		
			</center>

<div class="navy-dotted" style="margin-bottom:20px">
	無料セミナーのご予約は、各セミナー日程に表示された「予約」ボタンをご利用ください。<br />

	<span id="span-attention-1">
		【セミナーに関するお問い合わせ】<br />
		お問い合わせ前に必ずセミナー<a href="/qa_seminar.html" target="_blank">Q&A</a>をご覧ください。
	</span>


	<div class="area-btn-seminar">
		<div id="btn-seminar-inquiry-1">
			セミナーに関するお問い合わせはこちら <span class="icon-envelope2"></span>
		</div>
		<div id="area-seminar-inquiry-form">
			<div id="area-form-message"></div>

			<form id="form-seminar">
				<label>お問い合わせ内容</label><span class="mark-required">*</span><br />
				<select id="inquiry-type" name="inquiry_type">
					<option value="0">選択してください</option>
					<option value="1">セミナーが予約できない</option>
					<option value="2">セミナー内容について</option>
					<option value="3">開催場所について</option>
					<option value="4">その他セミナーに関して</option>
				</select><br /><br />

				<label>お問い合わせ詳細</label><span class="mark-required">*</span> <span class="attention-text">ご予約のセミナー名や会場等、お問い合わせの内容はできるだけ詳しくご記入ください。</span><br />
				<textarea id="area-textarea" name="inquiry_detail" style="ime-mode:active"></textarea><br />
				<span class="attention-text" style="color:#ff0000">※このフォームではセミナーに関するお問い合わせ以外は受け付けておりません。</span><span class="attention-text">※ <span class="mark-required">*</span>は必須項目です。</span><br /><br />

				<label>お名前</label><span class="mark-required">*</span> <input type="text" id="your-name" name="your_name" value="" style="ime-mode:active">
				<label>メール</label><span class="mark-required">*</span> <input type="text" id="your-email" name="your_email" value="" style="ime-mode:disabled">
				<br /><br />

				<input type="button" id="btn-submit" value="送信する">

				<center>お問い合わせ前に必ずセミナー<a href="/qa_seminar.html" target="_blank">Q&A</a>をご覧ください。</center>

			</form>
		</div>

	</div>

	【参加したいセミナーが無い場合】<br />
	　常設会場（東京・大阪）まで来られない<br />
	　希望の日程でセミナーが開催されていない<br />
	　セミナーの時間が合わない<br />
	など、参加したいセミナーが無い場合は、ご希望を教えてください。<br />
	セミナーの内容などについてもリクエストもお待ちしております。<br />

	<div class="area-btn-seminar">
		<a href="https://jp.surveymonkey.com/s/QNGSHFR" id="btn-seminar-inquiry-2" target="_blank">
			<span id="span-attention-2">ご希望のセミナーが無い場合はこちら</span><br />
			セミナーアンケートにご協力ください <span class="icon-forward"></span>
		</a>
	</div>


</div>



        </div>

	</div>

   </div>
 <!-- </div>-->


<?php fncMenuFooter($header_obj->footer_type); ?>

</body>
</html>
