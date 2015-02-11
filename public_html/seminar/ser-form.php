<?php
require_once '../include/header.php';

$header_obj = new Header();

$header_obj->title_page='セミナーに関するお問い合わせ';
$header_obj->description_page='ワーキングホリデー（ワーホリ）や留学をされる方向けの無料セミナー等のご案内をしています。ワーキングホリデー（ワーホリ）協定国の最新のビザ取得方法や渡航情報などを発信しています。オーストラリア、ニュージーランド、カナダ、韓国、フランス、ドイツ、イギリス、アイルランド、デンマーク、台湾、香港でワーキングホリデー（ワーホリ）ビザの取得が可能です。ワーキングホリデー（ワーホリ）ビザ以外に学生ビザでの留学などもお手伝い可能です。';

$header_obj->fncMenuHead_h1text = 'セミナーに関するお問い合わせ';

//add javascript for country info
$header_obj->add_js_files='
<script type="text/javascript" src="https://www.google.com/jsapi"></script><script src="/seminar/js/jquery.mobile-1.0rc2.min.js"></script>
<script type="text/javascript" src="/seminar/js/script-form.js"></script>
';


$header_obj->add_css_files='<link rel="stylesheet" href="/seminar/css/jquery.mobile-1.0rc2.min.css" /><link rel="stylesheet" href="/css/base_mobile.css" /><link rel="stylesheet" href="/seminar/css/themes/jawhm.css" /><link rel="stylesheet" href="/seminar/css/ser.css" /><link href="/seminar/css/style-m.css" rel="stylesheet" type="text/css" />';


$header_obj->display_header();

include('../../calendar_module/mod_event_horizontal.php');
?>

	<div id="maincontent">
		<?php echo $header_obj->breadcrumbs(''); ?>

		<div data-role="content" style="padding-bottom:0">
	        <ul data-role="listview" data-inset="true" data-theme="a" data-dividertheme="a">
	            <li data-role="list-divider">セミナーに関するお問い合わせ</li>
	        </ul>


			<span id="span-attention-1" class="link-qa-sp">※お問い合わせ前にセミナー<a href="/qa_seminar.html" target="_blank">Q&A</a>をご覧ください。</span>

			<div id="area-seminar-inquiry-form" class="area-seminar-inquiry-form-sp">

				<form id="form-seminar">
					<label>お問い合わせ内容</label><span class="mark-required">*</span><br>
					<select id="inquiry-type" name="inquiry_type">
						<option value="0">選択してください</option>
						<option value="1">セミナーが予約できない</option>
						<option value="2">セミナー内容について</option>
						<option value="3">開催場所について</option>
						<option value="4">その他セミナーに関して</option>
					</select><br><br>

					<label>お問い合わせ本文</label><span class="mark-required">*</span><br>
					<span class="attention-text" style="color:#ff0000">※このフォームではセミナーに関するお問い合わせ以外は受け付けておりません。</span><br>
					<span class="attention-text">ご予約のセミナー名や会場等、お問い合わせの内容はできるだけ詳しくご記入ください。</span><br>
					<textarea id="area-textarea" name="inquiry_detail"></textarea><br><br>

					<label>お名前</label><span class="mark-required">*</span><br>
					<input type="text" id="your-name" name="your_name" value=""><br><br>

					<label>メールアドレス</label><span class="mark-required">*</span><br>
					<input type="text" id="your-email" name="your_email" value="" type="email"><br>
					<span class="attention-text" style="text-align:right"><span class="mark-required">*</span>は必須項目です。</span><br><br>

					<input type="button" id="btn-submit" value="送信">
				</form>
				<span id="span-attention-1" class="link-qa-sp">※お問い合わせ前にセミナー<a href="/qa_seminar.html" target="_blank">Q&A</a>をご覧ください。</span>

				<div id="area-form-message"></div>

			</div>

			<a href="" data-rel="back" data-theme="c" class="ui-btn ui-shadow ui-corner-all ui-btn-up-c" style="width:50%;margin:0 auto 20px;padding:4px;border-radius:0.5em">戻る</a>

		</div>



	</div>
  </div>
  </div>

<?php fncMenuFooter($header_obj->footer_type); ?>

</body>
</html>