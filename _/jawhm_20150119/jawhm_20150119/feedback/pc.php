<?php
require_once '../include/header.php';

$header_obj = new Header();

$header_obj->title_page='アンケート';
$header_obj->description_page='ワーキングホリデー（ワーホリ）協定国の最新のビザ取得方法や渡航情報などを発信しています。また、ワーキングホリデー（ワーホリ）をされる方向けの各種無料セミナーを開催しています。オーストラリア、ニュージーランド、カナダ、韓国、フランス、ドイツ、イギリス、アイルランド、デンマーク、台湾、香港でワーキングホリデー（ワーホリ）ビザの取得が可能です。ワーキングホリデー（ワーホリ）ビザ以外に学生ビザでの留学などもお手伝い可能です。';

$header_obj->fncMenuHead_imghtml = '<img id="top-mainimg" src="../images/mainimg/top-mainimg.jpg" alt="" width="970" height="170" />';
$header_obj->fncMenuHead_h1text = 'アンケート';
$header_obj->display_header();

?>
	<div id="maincontent">
	  <?php echo $header_obj->breadcrumbs(); ?>

<?php

	mb_language("Ja");
	mb_internal_encoding("utf8");

	$e = @$_GET['e'];
	$act = @$_POST['act'];

	$seminar_title = '';
	if ($e == 'A10')	{
		$seminar_title = '７月１３日アイルランドセミナー';
	}
	if ($e == 'B10')	{
		$seminar_title = '７月１６日仙台セミナー';
	}

	if ($e <> '' && $seminar_title == '')	{
		try {
			$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);
			$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$db->query('SET CHARACTER SET utf8');
			$stt = $db->prepare('SELECT id, hiduke, date_format(starttime,\'%H:%i\') as sttime, date_format(endtime,\'%H:%i\') as edtime, place, k_use, k_title1, k_title2, k_desc1, k_desc2, k_stat, free, type, pax, booking, waitting FROM event_list WHERE id = '.$e.' ORDER BY id');
			$stt->execute();
			$idx = 0;
			while($row = $stt->fetch(PDO::FETCH_ASSOC)){
				$idx++;
				$cur_id = $row['id'];
				$cur_hiduke = $row['hiduke'];
				$cur_sttime = $row['sttime'];
				$cur_edtime = $row['edtime'];
				$cur_title1 = $row['k_title1'];
				$seminar_title = $cur_hiduke.'<br/>'.$cur_title1;
			}
			$db = NULL;
		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}

?>


<h2 class="sec-title">アンケート</h2>
<div id="feedback">


<?php
	if ($act == 'send')	{

		$vmail = 'info@jawhm.or.jp';
		$subject = "お客様フィードバック";

		$body  = '';
		$body .= '[お客様フィードバック]';
		$body .= chr(10);
		foreach($_POST as $post_name => $post_value){
			$body .= chr(10);
			$body .= $post_name." : ".$post_value;
		}
		$body .= chr(10);
		$body .= chr(10);
		$body .= '--------------------------------------';
		$body .= chr(10);
		foreach($_SERVER as $post_name => $post_value){
			$body .= chr(10);
			$body .= $post_name." : ".$post_value;
		}
		$body .= '';
		$from = mb_encode_mimeheader(mb_convert_encoding("日本ワーキングホリデー協会","JIS"))."<info@jawhm.or.jp>";
		mb_send_mail($vmail,$subject,$body,"From:".$from);


?>
	<p style="margin-top:20px;">
		アンケートへのご協力ありがとうございました。<br/>
		今後も、当協会では皆様のお力になれるサービスを心がけてまいります。<br/>
	</p>


<?php
	}else{
?>
	<p style="margin:10px 0 10px 0;">
		以下のフォームに入力をお願いします。<br/>
		※このアンケートは今後のセミナー等のサービス向上に利用させて頂きます。<br/>
		　また、皆様の声として今後公開させて頂く場合もございますので、予めご了承ください。<br/>
	</p>

<form method="post" action="./pc.php" onSubmit="return confirm('アンケートを送信します。よろしいですか？')">
	<input type="hidden" name="act" value="send">
	<input type="hidden" name="e" value="<?php echo $e; ?>">
	<table>
<?php
	if ($seminar_title <> '')	{
?>
		<tr>
			<td colspan="2">
				<div style="margin: 10px 0 10px 20px; font-weight:bold; font-size:11pt;">
					<?php echo $seminar_title; ?>
				</div>
				<input type="hidden" name="参加セミナー" value="<?php echo $seminar_title; ?>">
			</td>
		</tr>
<?php
	}
?>
	<tr>
		<td>年齢</td>
		<td>
			<input type="radio" name="年齢" value="16-18歳">&nbsp;16-18歳
			&nbsp;&nbsp;&nbsp;
			<input type="radio" name="年齢" value="19-22歳">&nbsp;19-22歳
			&nbsp;&nbsp;&nbsp;
			<input type="radio" name="年齢" value="23-26歳">&nbsp;23-26歳
			&nbsp;&nbsp;&nbsp;
			<input type="radio" name="年齢" value="27-30歳">&nbsp;27-30歳
			<input type="radio" name="年齢" value="31-39歳">&nbsp;31-39歳
			&nbsp;&nbsp;&nbsp;
			<input type="radio" name="年齢" value="40歳以上">&nbsp;40歳以上
		</td>
	</tr>

	<tr>
		<td>性別</td>
		<td>
			<input type="radio" value="男性" name="性別" />男性 &nbsp;&nbsp;
			<input type="radio" value="女性" name="性別"/>女性
		</td>
	</tr>
	<tr>
		<td>ビザの種類</td>
		<td>
			<input type="radio" name="ビザの種類" value="学生">&nbsp;学生
			&nbsp;&nbsp;&nbsp;
			<input type="radio" name="ビザの種類" value="ワーキングホリデー">&nbsp;ワーキングホリデー
			&nbsp;&nbsp;&nbsp;
			<input type="radio" name="ビザの種類" value="観光">&nbsp;観光
			&nbsp;&nbsp;&nbsp;
			<input type="radio" name="ビザの種類" value="その他">&nbsp;その他
			&nbsp;&nbsp;&nbsp;
			<input type="radio" name="ビザの種類" value="未定">&nbsp;未定
		</td>
	</tr>

	<tr>
		<td>ご職業</td>
		<td>
			<input type="radio" name="職業" value="学生">&nbsp;学生
			&nbsp;&nbsp;&nbsp;
			<input type="radio" name="職業" value="会社員">&nbsp;会社員
			&nbsp;&nbsp;&nbsp;
			<input type="radio" name="職業" value="自営業">&nbsp;自営業
			&nbsp;&nbsp;&nbsp;
			<input type="radio" name="職業" value="フリーター">&nbsp;フリーター
			&nbsp;&nbsp;&nbsp;
			<input type="radio" name="職業" value="その他">&nbsp;その他
		</td>
	</tr>

	<tr>
		<td>ご予算</td>

		<td>
			<input type="radio" name="予算" value="10～5万円">&nbsp;10～5万円
			&nbsp;&nbsp;&nbsp;
			<input type="radio" name="予算" value="60～100万円">&nbsp;60～100万円
			&nbsp;&nbsp;&nbsp;
			<input type="radio" name="予算" value="110～150万円">&nbsp;110～150万
			&nbsp;&nbsp;&nbsp;</br>
			<input type="radio" name="予算" value="160～200万円">&nbsp;160～200万
			&nbsp;&nbsp;&nbsp;
			<input type="radio" name="予算" value="200万円以上">&nbsp;200万円以上
		</td>
	</tr>
	<tr>
		<td nowrap>どこで当協会を<br/>知りましたか</td>
		<td>
			<input type="checkbox" name="協会認知1" value="協会ホームページ">&nbsp;協会ホームページ
			&nbsp;&nbsp;&nbsp;
			<input type="checkbox" name="協会認知2" value="留学エージェントの紹介">&nbsp;留学エージェントの紹介
			&nbsp;&nbsp;&nbsp;
			<input type="checkbox" name="協会認知3" value="書籍・雑誌">&nbsp;書籍・雑誌
			<br/>
			<input type="checkbox" name="協会認知4" value="友人の紹介">&nbsp;友人の紹介
			&nbsp;&nbsp;&nbsp;
			<input type="checkbox" name="協会認知5" value="大使館の紹介">&nbsp;大使館の紹介
			&nbsp;&nbsp;&nbsp;
			<input type="checkbox" name="協会認知6" value="学校の紹介">&nbsp;学校の紹介
			&nbsp;&nbsp;&nbsp;
			<input type="checkbox" name="協会認知7" value="その他">&nbsp;その他
			<br/>
		</td>
	</tr>

	<tr>
		<td>渡航予定国</td>
		<td>
			<input type="checkbox" name="渡航予定国1" value="オーストラリア">&nbsp;オーストラリア
			&nbsp;&nbsp;&nbsp;
			<input type="checkbox" name="渡航予定国2" value="ニュージーランド">&nbsp;ニュージーランド
			&nbsp;&nbsp;&nbsp;
			<input type="checkbox" name="渡航予定国3" value="カナダ">&nbsp;カナダ
			&nbsp;&nbsp;&nbsp;
			<input type="checkbox" name="渡航予定国4" value="韓国">&nbsp;韓国
			<br/>
			<input type="checkbox" name="渡航予定国5" value="フランス">&nbsp;フランス
			&nbsp;&nbsp;&nbsp;
			<input type="checkbox" name="渡航予定国6" value="ドイツ">&nbsp;ドイツ
			&nbsp;&nbsp;&nbsp;
			<input type="checkbox" name="渡航予定国7" value="イギリス">&nbsp;イギリス
			&nbsp;&nbsp;&nbsp;
			<input type="checkbox" name="渡航予定国8" value="アイルランド">&nbsp;アイルランド
			<br/>
			<input type="checkbox" name="渡航予定国9" value="デンマーク">&nbsp;デンマーク
			&nbsp;&nbsp;&nbsp;
			<input type="checkbox" name="渡航予定国10" value="台湾">&nbsp;台湾
			&nbsp;&nbsp;&nbsp;
			<input type="checkbox" name="渡航予定国11" value="香港">&nbsp;香港
			&nbsp;&nbsp;&nbsp;
			<input type="checkbox" name="渡航予定国12" value="未定">&nbsp;未定
		</td>
	</tr>
	<tr>
		<td nowrap>セミナーの満足度</td>

		<td>
		&nbsp;<br/>
		　悪い
			<input type="radio" name="満足度" value="1">&nbsp;1
			&nbsp;&nbsp;
			<input type="radio" name="満足度" value="2">&nbsp;2
			&nbsp;&nbsp;
			<input type="radio" name="満足度" value="3">&nbsp;3
			&nbsp;&nbsp;
			<input type="radio" name="満足度" value="4">&nbsp;4
			&nbsp;&nbsp;
			<input type="radio" name="満足度" value="5">&nbsp;5
		　良い
			<br/>
		&nbsp;<br/>
		</td>
	</tr>

	<tr>
		<td>≪感想≫</br>ご自由に<br/>ご記入ください</td>
		<td>
			<textarea name="感想" cols="5" rows="5"></textarea></br>
			(例：改善点、リクエスト、次回聞きたいことなど、具体的にご記入頂けると幸いです。)<br/>
		</td>
	</tr>

	<tr>
		<td colspan="2">
			<p align="right" style="font-size:11pt; margin:15px 0 15px 0;">
				セミナーにご参加頂きましてありがとうございました。<br/>
				今後の向上のため、皆様のご意見・ご感想を参考にさせて頂きます。<br/>
			</p>
		</td>
	</tr>

</table>
	<div style="text-align:right;">
	<input class="submit" type="submit" value="送信" style="width:150px; height:30px; margin:18px 0 30px 0; font-size:11pt; font-weight:bold;" />
    </div>

</form>

</div>

<?php
	}
?>

	</div>


	</div>
  </div>
  </div>
  <div id="footer">

<?php fncMenuFooter($header_obj->footer_type); ?>

</body>
</html>

