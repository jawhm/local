<?php

	require_once 'reqcheck.php';

?>
<?php
require_once '../include/header.php';

$header_obj = new Header();

$header_obj->title_page='メンバー専用ページ';
$header_obj->description_page='ワーキングホリデー（ワーホリ）協定国の最新のビザ取得方法や渡航情報などを発信しています。また、ワーキングホリデー（ワーホリ）をされる方向けの各種無料セミナーを開催しています。オーストラリア、ニュージーランド、カナダ、韓国、フランス、ドイツ、イギリス、アイルランド、デンマーク、台湾、香港でワーキングホリデー（ワーホリ）ビザの取得が可能です。ワーキングホリデー（ワーホリ）ビザ以外に学生ビザでの留学などもお手伝い可能です。';
$header_obj->add_js_files='<script type="text/javascript" src="/js/jquery.corner.js"></script>
<script>
function fnc_logout()	{
	if (confirm("ログアウトしますか？"))	{
		location.href = "/member/logout.php";
	}
}
</script>
';
$header_obj->fncMenuHead_imghtml = '<img id="top-mainimg" src="../images/mainimg/top-mainimg.jpg" alt="" width="970" height="170" />';
$header_obj->fncMenuHead_h1text = 'メンバー専用ページ';
$header_obj->full_link_tag = true;

$header_obj->display_header();

?>
	<div id="maincontent">
	  <?php echo $header_obj->breadcrumbs(); ?>
	<div id="logout-btn">
		<input type="button" value="　ログアウト　" onClick="fnc_logout();">
	</div>

	<h2 class="sec-title">メンバー限定セミナーを予約する</h2>
		<p class="text01">
			メンバー限定セミナーを予約する場合は、<a href="./seminar.php">こちらからどうぞ</a><br/>
		</p>
	<h2 class="sec-title" id="event">セミナーにオンラインで参加する</h2>
		<p class="text01">
			東京で開催されているセミナーはオンラインでご覧いただくことが可能です。<br/>
			ご覧になりたい場合は、<a href="./onlineseminar.php">こちらから専用URLを取得</a>してください。<br/>
		</p>
	<h2 class="sec-title" id="event">メンバー情報を変更する</h2>
		<p class="text01">
			ログインパスワードを変更する場合は、<a href="./memreg.php">こちらからどうぞ</a><br/>
		</p>
		<p class="text01">
			ご登録頂いた住所、電話番号等の変更は、現在WEB上から行うことができません。<br/>
			お手数ですが、会員番号と変更内容を明記の上、 toiawase@jawhm.or.jp までご連絡ください。<br/>
		</p>
	<h2 class="sec-title" id="event">個別カウンセリングを予約する</h2>
		<p class="text01">
			個別カウンセリングが完全予約制となっております。<br/>
			ご予約は電話又はメールにて承っておりますので、ご予約の際はご連絡くださいませ。<br/>
			&nbsp;<br/>
			【東京オフィス】<br/>
			電話　：03-6304-5858<br/>
			メール：sodan@jawhm.or.jp<br/>
			&nbsp;<br/>
			【大阪オフィス】<br/>
			電話　：06-6346-3774<br/>
			メール：sodan-osaka@jawhm.or.jp<br/>
			&nbsp;<br/>
			【名古屋オフィス】<br/>
			電話　：052-462-1585<br/>
			メール：sodan-nagoya@jawhm.or.jp<br/>
			&nbsp;<br/>
			【福岡オフィス】<br/>
			電話　：092-739-0707<br/>
			メール：sodan-fukuoka@jawhm.or.jp<br/>
			&nbsp;<br/>
			※個別カウンセリングは時期によって混雑し、ご予約が取りづらくなる場合がございます。<br/>
			　ご予約の際はご日程に余裕を持ってご連絡頂けますよう、お願い申し上げます。<br/>
		</p>
	<div style="height:30px;">&nbsp;</div>

<div style="text-align:center;">
	<img src="../images/flag01.gif">
	<img src="../images/flag03.gif">
	<img src="../images/flag09.gif">
	<img src="../images/flag05.gif">
	<img src="../images/flag06.gif">
	<img src="../images/mflag11.gif" width="40" height="26">
	<img src="../images/flag08.gif">
	<img src="../images/flag04.gif">
	<img src="../images/flag02.gif">
	<img src="../images/flag10.gif">
	<img src="../images/flag07.gif">
</div>

	<div style="height:50px;">&nbsp;</div>

	</div>


	</div>
  </div>
  </div>

<?php fncMenuFooter($header_obj->footer_type); ?>

</body>
</html>

