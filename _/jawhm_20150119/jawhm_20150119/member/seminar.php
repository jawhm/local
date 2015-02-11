<?php

require_once 'reqcheck.php';

include '../seminar_module/seminar_module.php';

$default = 'tokyo';
if (!empty($_GET['place'])) {
	$default = $_GET['place'];
}

$config = array(
	'view_mode' => 'list',
	'list' => array(
		'use_area' => 'off',
		'place_default' => $default,
		'member_only' => 'true',
	)
);
$sm = new SeminarModule($config);

$redirection = '/seminar/ser/page/member';

require_once '../include/header.php';

$header_obj = new Header();

$header_obj->mobileredirect=$redirection;

$header_obj->title_page='メンバー限定セミナー予約';
$header_obj->description_page='ワーキングホリデー（ワーホリ）協定国の最新のビザ取得方法や渡航情報などを発信しています。また、ワーキングホリデー（ワーホリ）をされる方向けの各種無料セミナーを開催しています。オーストラリア、ニュージーランド、カナダ、韓国、フランス、ドイツ、イギリス、アイルランド、デンマーク、台湾、香港でワーキングホリデー（ワーホリ）ビザの取得が可能です。ワーキングホリデー（ワーホリ）ビザ以外に学生ビザでの留学などもお手伝い可能です。';

$header_obj->add_js_files  = $sm->get_add_js() . '<script type="text/javascript" src="/js/jquery.corner.js"></script>
<script>
function fnc_logout()	{
	if (confirm("ログアウトしますか？"))	{
		location.href = "/member/logout.php";
	}
}
</script>
';
$header_obj->add_css_files = $sm->get_add_css();
$header_obj->add_style     = $sm->get_add_style();

$header_obj->fncMenuHead_imghtml = '<img id="top-mainimg" src="../images/mainimg/seminar-mainimg.jpg" alt="" width="970" height="170" />';
$header_obj->fncMenuHead_h1text = 'メンバー限定セミナー情報 | メンバー専用ページ';

$header_obj->display_header();

?>
	<div id="maincontent">
    	  <?php echo $header_obj->breadcrumbs('member-top'); ?>

	<div id="logout-btn">
		<input type="button" value="　ログアウト　" onClick="fnc_logout();">
	</div>

	<h2 class="sec-title">セミナーのご案内</h2>

	<div style="padding-left:30px;">
		<p>ワーキングホリデーセミナーではワーキングホリデーのビザの取得方法</p>
		<p>ワーキングホリデービザで出来ること</p>
		<p>ワーキングホリデーに必要なもの</p>
		<p>各国の特徴</p>
		<p>ワーキングホリデー最近の傾向</p>

		<p>ワーキングホリデーに興味はあるけど何から始めていいのか分からない方</p>
		<p>各セミナーには質疑応答時間もありますので</p>
		<p>遠慮されずに積極的に質問してくださいね。</p>
		<p>現地でのアルバイトやシェアハウスの見つけ方等</p>
		<p>なんでもご質問にお答え致します</p>

		<p>お友達も御誘いのうえご参加くださいませ</p>
	</div>

		  <div style="border: 2px dotted navy; margin: 20px 0 10px 0; padding: 5px 10px 5px 10px; font-size:12pt;">
			  こちらのページでは、メンバー限定セミナーのみご案内しております。<br/>
			  <a href="../seminar.html">無料セミナーのご予約はこちら</a>からお願いいたします。<br/>
		  </div>

		  <div style="border: 2px dotted navy; margin: 10px 0 10px 0; padding: 5px 10px 5px 10px; font-size:12pt;">
			  セミナーのご予約は、各セミナー日程に表示された「予約」ボタンをご利用ください。<br/>
			  各セミナーへのご質問は toiawase@jawhm.or.jp　にメールをお願いいたします。<br/>
			  なお、当日のセミナーのご予約は、03-6304-5858までご連絡ください。<br/>
		  </div>

		  <div style="border: 2px dotted navy; margin: 10px 0 10px 0; padding: 5px 10px 5px 10px; font-size:10pt;">
			  【ご注意：スマートフォンをご利用の方へ】<br/>
			  スマートフォンなど、ＰＣ以外のブラウザからご利用された場合、予約フォームが正しく機能しない場合があります。<br/>
			  この場合、お手数ですが、以下の内容を toiawase@jawhm.or.jp までご連絡ください。<br/>
			  　・　参加希望のセミナー日程<br/>
			  　・　会員番号<br/>
			  　・　お名前<br/>
		  </div>

	<div style="padding-left:30px; margin-top: 30px;">
		<?php $sm->show(); ?>

<?php
/*
		if (count($tyo_title) == 0)	{
?>
			<div style="border: 2px dotted pink; margin: 10px 0 10px 0; padding: 5px 10px 5px 10px; font-size:12pt;">
			現在、東京会場で予定されているセミナーはありません。<br/>
			</div>
<?php
		}else{
			for ($idx=0; $idx<count($tyo_title); $idx++)	{
				print '<div style="height:20px;" id="'.$tyo_ymd[$idx].'"> </div>';
				print '<div style="width:620px; margin:7px 0 0 -15px; padding-left:15px; font-size:11pt; color:navy; border-left:3px solid red; border-bottom:1px solid red;">';
				if ($tyo_ymd[$idx] < date('Ymd'))	{
					print '終了しました　<s>'.$tyo_title[$idx].'</s>';
				}else{
					print $tyo_btn[$idx].'&nbsp;&nbsp;'.$tyo_title[$idx];
				}
				print '</div>';
				print '<table><tr><td>'.$tyo_img[$idx].'</td>';
				print '<td><p>'.nl2br($tyo_desc[$idx]).'</p></td></tr></table>';
			}
		}
?>
	</div>

	<h2 class="sec-title" id="osaka-semi">大阪セミナー</h2>
	<p>セミナーのご予約は、「予約」ボタンから予約フォームをご利用ください。<br/>
	予約フォームがご利用できない場合は、お名前・会員番号を明記の上、 toiawase@jawhm.or.jp までご連絡下さい。</p>

	<div style="border: 2px solid springgreen; font-size:11pt; margin:10px 0 10px 0; padding: 10px 5px 10px 5px;">
		大阪セミナー開催場所<br/>
		　　大阪市北区梅田1-11-4-500　大阪駅前第4ビル5階 19-1号室<br/>
		　　JR大阪駅より徒歩5分<br/>
		<span style="font-size:9pt;">
		　　<a href="#osaka-semi" onClick="window.open('./event/osaka-map.html', '', 'width=600,height=550'); return false;">地図を表示する</a>（別ウィンドウで開きます。ポップアップブロッカーを解除してください。）<br/>
		</spna>
	</div>

	<div style="padding-left:30px;">
<?php
		if (count($osa_title) == 0)	{
?>
			<div style="border: 2px dotted pink; margin: 10px 0 10px 0; padding: 5px 10px 5px 10px; font-size:12pt;">
			現在、大阪会場で予定されているセミナーはありません。<br/>
			</div>
<?php
		}else{
			for ($idx=0; $idx<count($osa_title); $idx++)	{
				print '<div style="height:20px;" id="'.$osa_ymd[$idx].'"> </div>';
				print '<div style="width:620px; margin:7px 0 0 -15px; padding-left:15px; font-size:11pt; color:navy; border-left:3px solid red; border-bottom:1px solid red;">';
				if ($osa_ymd[$idx] < date('Ymd'))	{
					print '終了しました　<s>'.$osa_title[$idx].'</s>';
				}else{
					print $osa_btn[$idx].'&nbsp;&nbsp;'.$osa_title[$idx];
				}
				print '</div>';
				print '<table><tr><td>'.$osa_img[$idx].'</td>';
				print '<td><p>'.nl2br($osa_desc[$idx]).'</p></td></tr></table>';
			}
		}
?>
	</div>

<!--
	<h2 class="sec-title" id="sendai-semi">仙台セミナー</h2>
	<p>セミナーのご予約は、「予約」ボタンから予約フォームをご利用ください。<br/>
	予約フォームがご利用できない場合は、お名前・会員番号を明記の上、 toiawase@jawhm.or.jp までご連絡下さい。</p>

	<div style="border: 2px solid springgreen; font-size:11pt; margin:10px 0 10px 0; padding: 10px 5px 10px 5px;">
		仙台セミナー開催場所<br/>
		　　青葉区中央市民センター<br/>
		　　仙台市青葉区一番町２－１－４<br/>
		　　仙台駅から徒歩５分程度です<br/>
		<span style="font-size:9pt;">
		　　<a href="#sendai-semi" onclick="window.open('./event/sendai-map.html', '', 'width=600,height=550'); return false;">地図を表示する</a>（別ウィンドウで開きます。ポップアップブロッカーを解除してください。）<br/>
		</spna>
	</div>

	<div style="padding-left:30px;">
<?php
		if (count($sen_title) == 0)	{
?>
			<div style="border: 2px dotted pink; margin: 10px 0 10px 0; padding: 5px 10px 5px 10px; font-size:12pt;">
			現在、仙台会場で予定されているセミナーはありません。<br/>
			</div>
<?php
		}else{
			for ($idx=0; $idx<count($sen_title); $idx++)	{
				print '<div style="height:20px;" id="'.$sen_ymd[$idx].'"> </div>';
				print '<div style="width:620px; margin:7px 0 0 -15px; padding-left:15px; font-size:11pt; color:navy; border-left:3px solid red; border-bottom:1px solid red;">';
				if ($sen_ymd[$idx] < date('Ymd'))	{
					print '終了しました　<s>'.$sen_title[$idx].'</s>';
				}else{
					print $sen_btn[$idx].'&nbsp;&nbsp;'.$sen_title[$idx];
				}
				print '</div>';
				print '<table><tr><td>'.$sen_img[$idx].'</td>';
				print '<td><p>'.nl2br($sen_desc[$idx]).'</p></td></tr></table>';
			}
		}
?>
	</div>
-->


	<h2 class="sec-title" id="fukuoka-semi">福岡セミナー</h2>
	<p>セミナーのご予約は、「予約」ボタンから予約フォームをご利用ください。<br/>
	予約フォームがご利用できない場合は、お名前・会員番号を明記の上、 toiawase@jawhm.or.jp までご連絡下さい。</p>

	<div style="border: 2px solid springgreen; font-size:11pt; margin:10px 0 10px 0; padding: 10px 5px 10px 5px;">
		福岡セミナー開催場所<br/>
		　　CafeBar Manly　マンリーカフェ　　<a href="http://www.hotpepper.jp/strJ000761870/" target="_blank">http://www.hotpepper.jp/strJ000761870/</a><br/>
		　　カフェ内にて開催します。<br/>
		　　福岡県福岡市中央区今泉1‐18‐55<br/>
		<span style="font-size:9pt;">
		　　<a href="#fukuoka-semi" onClick="window.open('./event/fukuoka-map.html', '', 'width=600,height=600'); return false;">地図を表示する</a>（別ウィンドウで開きます。ポップアップブロッカーを解除してください。）<br/>
		</spna>
	</div>

	<div style="padding-left:30px;">

<?php
		if (count($fuk_title) == 0)	{
?>
			<div style="border: 2px dotted pink; margin: 10px 0 10px 0; padding: 5px 10px 5px 10px; font-size:12pt;">
			現在、福岡会場で予定されているセミナーはありません。<br/>
			</div>
<?php
		}else{
			for ($idx=0; $idx<count($fuk_title); $idx++)	{
				print '<div style="height:20px;" id="'.$fuk_ymd[$idx].'"> </div>';
				print '<div style="width:620px; margin:7px 0 0 -15px; padding-left:15px; font-size:11pt; color:navy; border-left:3px solid red; border-bottom:1px solid red;">';
				if ($fuk_ymd[$idx] < date('Ymd'))	{
					print '終了しました　<s>'.$fuk_title[$idx].'</s>';
				}else{
					print $fuk_btn[$idx].'&nbsp;&nbsp;'.$fuk_title[$idx];
				}
				print '</div>';
				print '<table><tr><td>'.$fuk_img[$idx].'</td>';
				print '<td><p>'.nl2br($fuk_desc[$idx]).'</p></td></tr></table>';
			}
		}
?>
	</div>


	<h2 class="sec-title" id="sendai-semi">仙台セミナー</h2>
	<p>セミナーのご予約は、「予約」ボタンから予約フォームをご利用ください。<br/>
	予約フォームがご利用できない場合は、お名前・会員番号を明記の上、 toiawase@jawhm.or.jp までご連絡下さい。</p>

<!---
	<div style="border: 2px solid springgreen; font-size:11pt; margin:10px 0 10px 0; padding: 10px 5px 10px 5px;">
		仙台セミナー開催場所<br/>
		　　CafeBar Manly　マンリーカフェ　　<a href="http://www.hotpepper.jp/strJ000761870/" target="_blank">http://www.hotpepper.jp/strJ000761870/</a><br/>
		　　カフェ内にて開催します。<br/>
		　　福岡県福岡市中央区今泉1‐18‐55<br/>
		<span style="font-size:9pt;">
		　　<a href="#sendai-semi" onclick="window.open('./event/sendai-map.html', '', 'width=600,height=600'); return false;">地図を表示する</a>（別ウィンドウで開きます。ポップアップブロッカーを解除してください。）<br/>
		</spna>
	</div>
--->

	<div style="padding-left:30px;">

<?php
		if (count($sen_title) == 0)	{
?>
			<div style="border: 2px dotted pink; margin: 10px 0 10px 0; padding: 5px 10px 5px 10px; font-size:12pt;">
			現在、仙台会場で予定されているセミナーはありません。<br/>
			</div>
<?php
		}else{
			for ($idx=0; $idx<count($sen_title); $idx++)	{
				print '<div style="height:20px;" id="'.$sen_ymd[$idx].'"> </div>';
				print '<div style="width:620px; margin:7px 0 0 -15px; padding-left:15px; font-size:11pt; color:navy; border-left:3px solid red; border-bottom:1px solid red;">';
				if ($sen_ymd[$idx] < date('Ymd'))	{
					print '終了しました　<s>'.$sen_title[$idx].'</s>';
				}else{
					print $sen_btn[$idx].'&nbsp;&nbsp;'.$sen_title[$idx];
				}
				print '</div>';
				print '<table><tr><td>'.$sen_img[$idx].'</td>';
				print '<td><p>'.nl2br($sen_desc[$idx]).'</p></td></tr></table>';
			}
		}
?>
	</div>


	<h2 class="sec-title" id="okinawa-semi">沖縄セミナー</h2>
	<p>セミナーのご予約は、「予約」ボタンから予約フォームをご利用ください。<br/>
	予約フォームがご利用できない場合は、お名前・会員番号を明記の上、 toiawase@jawhm.or.jp までご連絡下さい。</p>

	<div style="border: 2px solid springgreen; font-size:11pt; margin:10px 0 10px 0; padding: 10px 5px 10px 5px;">
		沖縄セミナー開催場所<br/>
		　　e-sa （イーサ）<br/>
		<span style="font-size:9pt;">
		　　<a href="#okinawa-semi" onClick="window.open('./event/okinawa-map.html', '', 'width=600,height=600'); return false;">地図を表示する</a>（別ウィンドウで開きます。ポップアップブロッカーを解除してください。）<br/>
		</spna>
	</div>

	<div style="padding-left:30px;">

<?php
		if (count($oka_title) == 0)	{
?>
			<div style="border: 2px dotted pink; margin: 10px 0 10px 0; padding: 5px 10px 5px 10px; font-size:12pt;">
			現在、沖縄会場で予定されているセミナーはありません。<br/>
			</div>
<?php
		}else{
			for ($idx=0; $idx<count($oka_title); $idx++)	{
				print '<div style="height:20px;" id="'.$oka_ymd[$idx].'"> </div>';
				print '<div style="width:620px; margin:7px 0 0 -15px; padding-left:15px; font-size:11pt; color:navy; border-left:3px solid red; border-bottom:1px solid red;">';
				if ($oka_ymd[$idx] < date('Ymd'))	{
					print '終了しました　<s>'.$oka_title[$idx].'</s>';
				}else{
					print $oka_btn[$idx].'&nbsp;&nbsp;'.$oka_title[$idx];
				}
				print '</div>';
				print '<table><tr><td>'.$oka_img[$idx].'</td>';
				print '<td><p>'.nl2br($oka_desc[$idx]).'</p></td></tr></table>';
			}
		}
*/
?>
	</div>

	<div style="height:30px;">&nbsp;</div>



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
<?php
/*
<div id="yoyakuform" style="display:none; margin:15px 20px 15px 20px; font-size:10pt; cursor:default;">

	<div style="font-size:12pt; font-weight:bold; margin:0 0 8px 0;">セミナー　予約フォーム</div>

	<form name="form_yoyaku">
	<table style="width:560px;">
		<tr style="background-color:lightblue;">
			<td nowrap style="text-align:right;">セミナー名&nbsp;</td>
			<td id="form_title" style="text-align:left;"></td>
			<input type="hidden" name="セミナー名" id="txt_title" value="">
			<input type="hidden" name="セミナー番号" id="txt_id" value="">
		</tr>
		<tr>
			<td nowrap style="border-bottom: 1px dotted pink; text-align:right;">お名前&nbsp;</td>
			<td style="border-bottom: 1px dotted pink; text-align:left;"><?php echo $mem_namae; ?>様
				<input type="hidden" name="お名前" id="txt_name" value="<?php echo $mem_namae; ?>" size=20>
				<input type="hidden" name="フリガナ" id="txt_furigana" value="<?php echo $mem_furigana; ?>" size=20>
				<input type="hidden" name="メール" id="txt_mail" value="<?php echo $mem_email; ?>" size=40><br/>
				<input type="hidden" name="電話番号" id="txt_tel" value="<?php echo $mem_tel; ?>" size=20>
			</td>
		</tr>
		<tr style="background-color:white;">
			<td nowrap style="border-bottom: 1px dotted pink; text-align:right;">興味のある国&nbsp;</td>
			<td style="border-bottom: 1px dotted pink; text-align:left;"><input type="text" name="興味国" id="txt_kuni" value="<?php echo $mem_country; ?>" size=50></td>
		</tr>
		<tr>
			<td nowrap style="border-bottom: 1px dotted pink; text-align:right;">出発予定時期&nbsp;</td>
			<td style="border-bottom: 1px dotted pink; text-align:left;"><input type="text" name="出発時期" id="txt_jiki" value="" size=50></td>
		</tr>
		<tr style="background-color:white;">
			<td nowrap style="text-align:right;">その他&nbsp;</td>
			<td style="text-align:left;"><input type="text" name="その他" id="txt_memo" value="" size=50></td>
		</tr>
	</table>
	</form>

	<div style="font-size:9pt; font-weight:bold; margin:10px 0 10px 0; border: 1px dotted navy;;">
		【携帯のメールアドレスをご利用の方へ】<br/>
		予約確認のメールをお送り致しますので、<br/>
		jawhm.or.jpからのメール（ＰＣメール）が受信できる状態にしておいてください。<br/>
	</div>

	<div id="div_wait" style="display:none;">
		<img src="../images/ajaxwait.gif">
		&nbsp;予約処理中です。しばらくお待ちください。&nbsp;
		<img src="../images/ajaxwait.gif">
	</div>

	<input type="button" class="button_cancel" value=" 取消 " onClick="btn_cancel();">　　　　　
	<input type="button" class="button_submit" value=" 送信 " id="btn_soushin" onClick="btn_submit();">

</div>

 */
?>

<?php fncMenuFooter($header_obj->footer_type); ?>

</body>
</html>

