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

$config = array();
//$config = array('view_mode' => 'list');
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

$header_obj->fncMenuHead_imghtml = '<img id="top-mainimg" src="../images/mainimg/seminar-mainimg.jpg" alt="" />';


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
				<td width="45%">●　ワーキングホリデービザの取得方法</td>
				<td width="10%">&nbsp;</td>
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
		<div style="float:left; padding-top:18px;">
			<p>
			&nbsp;<br/>
			各セミナーには質疑応答時間もありますので、遠慮されずに積極的に質問してくださいね。<br/>
			&nbsp;<br/>
			現地でのアルバイトやシェアハウスの見つけ方等、なんでもご質問にお答え致します。<br/>
			お友達もお誘いの上、どうぞご参加ください。<br/>
			&nbsp;<br/>
			&nbsp;<br/>
			また、参加者の９割の方は、お一人でのご参加です。<br/>
			お一人でもお気軽にお越しください。<br/>
			</p>
		</div>
		<div style="float:left;">
			<a href="/seminar/seminar_syoshin.php"><img src="/seminar/images/web_banner_syoshin.png" alt="初心者セミナー"></a>
		<br/>
			<table style="margin-right">
			<a href="/katsuyou.html"><img src="/images/member.png" alt="メンバー登録のススメ"></a>
			</table>
		</div>

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
        </div>

	</div>    	

   </div> 
 <!-- </div>-->
<div id="feedbox" style="display:none;">
<div style="color:navy; font-weight:bold; font-size:12pt;">
ご希望のセミナーが無い場合は、あなたが理想とするセミナーをリクエストしてください
</div>

<form id="feedform">
<center>
	<table border="1">
		<tr>
			<th>希望地域</th>
			<th>希望曜日</th>
			<th>希望時間</th>
			<th>セミナー内容</th>
			<th>その他</th>
		</tr>
		<tr>
			<td nowrap style="text-align:left; vertical-align:top; padding: 3px 4px 0 6px;">
				<input type="checkbox" name="開催地1" value="東京"> 東京　
				<input type="checkbox" name="開催地2" value="大阪"> 大阪<br/>
				<input type="checkbox" name="開催地3" value="福岡"> 福岡　
				<input type="checkbox" name="開催地4" value="沖縄"> 沖縄<br/>
				<div style="font-size:8pt; font-weight:bold; margin-top:5px;">
					常設会場以外の地域でも<br/>　　リクエストしてください
				</div>
				その他：<input type="text" name="開催地T" value="" size="10"><br/>
			</td>
			<td nowrap style="text-align:left; vertical-align:top; padding: 3px 4px 0 6px;">
				<input type="checkbox" name="曜日1" value="月曜日"> 月曜日　
				<input type="checkbox" name="曜日2" value="火曜日"> 火曜日<br/>
				<input type="checkbox" name="曜日3" value="水曜日"> 水曜日　
				<input type="checkbox" name="曜日4" value="木曜日"> 木曜日<br/>
				<input type="checkbox" name="曜日5" value="金曜日"> 金曜日　
				<input type="checkbox" name="曜日6" value="土曜日"> 土曜日<br/>
				<input type="checkbox" name="曜日7" value="日曜日"> 日曜日　
				<input type="checkbox" name="曜日8" value="祝祭日"> 祝祭日<br/>
			</td>
			<td nowrap style="text-align:left; vertical-align:top; padding: 3px 4px 0 6px;">
				<input type="checkbox" name="時間1" value="午前（１１時頃）"> 午前（１１時頃から）<br/>
				<input type="checkbox" name="時間2" value="午後（１時頃）"> 午後（１時頃から）<br/>
				<input type="checkbox" name="時間3" value="午後（３時頃）"> 午後（３時頃から）<br/>
				<input type="checkbox" name="時間4" value="夕方（５時頃）"> 夕方（５時頃から）<br/>
				<input type="checkbox" name="時間5" value="夜間（７時頃）"> 夜間（７時頃から）<br/>
			</td>
			<td nowrap style="text-align:left; vertical-align:top; padding: 3px 4px 0 6px;">
				<input type="checkbox" name="内容1" value="ビザについて"> ビザについて<br/>
				<input type="checkbox" name="内容2" value="海外生活について"> 海外生活について<br/>
				<input type="checkbox" name="内容3" value="語学の勉強について"> 語学の勉強について<br/>
				<input type="checkbox" name="内容4" value="都市の案内"> 都市の案内<br/>
				<input type="checkbox" name="内容5" value="資格について"> 資格について<br/>
			</td>
			<td nowrap style="text-align:left; vertical-align:top; padding: 3px 4px 0 6px;">
				ご自由にどうそ<br/>
				<textarea cols="5" rows="4" name="備考"></textarea>
			</td>
		</tr>
		<tr>
			<td colspan="5">
				ご連絡を希望される場合に入力してください。<br/>
				　　お名前 <input type="text" name="お名前" value="" size="20">　　
				　　メール <input type="text" name="メール" value="" size="40">
			</td>
		</tr>
	</table>
	<div style="margin-top:10px;">
		<input style="background:gainsboro; font-weight:bold;" id="feedhide" type="button" value="　　閉じる　　" />　　
		<input style="background:gainsboro; font-weight:bold;" type="submit" value="　リクエストする（送信）　" />
	</div>
</center>
</form>

</div>

<?php fncMenuFooter($header_obj->footer_type); ?>

</body>
</html>

