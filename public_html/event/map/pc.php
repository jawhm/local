<?php
require_once '../../include/header.php';

$header_obj = new Header();

$header_obj->title_page='セミナー会場・オフィスのご案内';
$header_obj->description_page='ワーキングホリデー（ワーホリ）協定国の最新のビザ取得方法や渡航情報などを発信しています。また、ワーキングホリデー（ワーホリ）をされる方向けの各種無料セミナーを開催しています。オーストラリア、ニュージーランド、カナダ、韓国、フランス、ドイツ、イギリス、アイルランド、デンマーク、台湾、香港でワーキングホリデー（ワーホリ）ビザの取得が可能です。ワーキングホリデー（ワーホリ）ビザ以外に学生ビザでの留学などもお手伝い可能です。';
$header_obj->fncMenuHead_h1text = 'セミナー会場・オフィスのご案内';

$header_obj->add_js_files='<script>
function PrintPage(){
	if(document.getElementById || document.layers){
		window.print();		//印刷をします
	}
}
</script>';

$header_obj->fncMenuHead_imghtml = '<img id="top-mainimg" src="../../images/top-mainimg.jpg" alt="" width="970" height="170" />';
$header_obj->fncMenuHead_link = 'nolink';
$header_obj->fncMenubar_function = false;

$header_obj->display_header();

if($header_obj->mobilepage && $header_obj->tablet_type === false)
{
	$iframe_width = 300;
	$iframe_height = 300;

}
else
{
	$iframe_width = 550;
	$iframe_height = 360;
}
?>
	<div id="maincontent" class="marginL150">
	  <?php echo $header_obj->breadcrumbs(); ?>
	<div id="top-main" style="width:660px;margin-bottom:20px;">

		<div class="event-map" style="text-align:right;">
			<input type="button" value="このページを印刷" onclick="javascript:PrintPage();" style="width:200px; font-size:11pt;"><br/>
		</div>

<?
	if (@$_GET['p'] == 'tokyo' || @$_GET['p'] == '')	{
?>

		<h2 class="sec-title">東京会場</h2>
		<div class="top-entry01 event-map">
			<div style="font-size:14pt;">東京セミナー会場
				<a href="/office/tokyo/" style="margin-left:30px;color:navy;font-size:10pt;">東京オフィスのご案内</a></div>
			<div style="font-size:11pt;">
			東京都新宿区西新宿1-3-3<br/>
			当日の連絡先：03-6304-5858<br/>
			&nbsp;<br/>
			【JR新宿駅西口B16から徒歩1分！】<br/>
			JR新宿西口のB16出口/大江戸線新宿西口駅を出てまっすぐ行くと「パチンコジャンボ新宿」がございます。ワーキングホリデー（ワーホリ）協会新宿オフィスは同ビル5階です。<br/>
			道を渡った斜め向かいには「ユニクロ新宿西口店」があります。初めてのご来店で道に迷った時は新宿に到着後、駅員さんに「ユニクロ新宿西口店」 までの行き方をきいて、そこから斜め向かいの「パチンコジャンボ新宿」を見つけると簡単です。<br/>
			JR新宿駅 西口改札からのより詳細なアクセス方法は<font color="red"><u><a href="http://www.jawhm.or.jp/blog/tokyoblog/item/496" target="_blank">こちら</a></u></font>を参照下さい。<br/>
			</div>
			&nbsp;<br/>
			<iframe width="<?php echo $iframe_width;?>" height="<?php echo $iframe_height;?>" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://www.google.co.jp/maps?f=q&amp;source=s_q&amp;hl=ja&amp;geocode=&amp;q=%E6%9D%B1%E4%BA%AC%E9%83%BD%E6%96%B0%E5%AE%BF%E5%8C%BA%E8%A5%BF%E6%96%B0%E5%AE%BF1-3-3&amp;aq=&amp;sll=36.5626,136.362305&amp;sspn=47.794907,63.457031&amp;brcurrent=3,0x60188cd701e48371:0x392ba008ab2d3ff3,0,0x60188cd65603f5bf:0xe3106be06aa76565&amp;ie=UTF8&amp;hq=&amp;hnear=%E6%9D%B1%E4%BA%AC%E9%83%BD%E6%96%B0%E5%AE%BF%E5%8C%BA%E8%A5%BF%E6%96%B0%E5%AE%BF%EF%BC%91%E4%B8%81%E7%9B%AE%EF%BC%93%E2%88%92%EF%BC%93&amp;ll=35.693204,139.698887&amp;spn=0.020912,0.051413&amp;z=14&amp;iwloc=A&amp;output=embed"></iframe><br /><small><a target="_new" href="http://www.google.co.jp/maps?f=q&amp;source=embed&amp;hl=ja&amp;geocode=&amp;q=%E6%9D%B1%E4%BA%AC%E9%83%BD%E6%96%B0%E5%AE%BF%E5%8C%BA%E8%A5%BF%E6%96%B0%E5%AE%BF1-3-3&amp;aq=&amp;sll=36.5626,136.362305&amp;sspn=47.794907,63.457031&amp;brcurrent=3,0x60188cd701e48371:0x392ba008ab2d3ff3,0,0x60188cd65603f5bf:0xe3106be06aa76565&amp;ie=UTF8&amp;hq=&amp;hnear=%E6%9D%B1%E4%BA%AC%E9%83%BD%E6%96%B0%E5%AE%BF%E5%8C%BA%E8%A5%BF%E6%96%B0%E5%AE%BF%EF%BC%91%E4%B8%81%E7%9B%AE%EF%BC%93%E2%88%92%EF%BC%93&amp;ll=35.693204,139.698887&amp;spn=0.020912,0.051413&amp;z=14&amp;iwloc=A" style="color:#0000FF;text-align:left" target="_blank">大きな地図で見る</a></small>
		</div>
		&nbsp;<br/>
		<div class="aiu-link-block">
			<a target="_blank" href="http://www.aiu.co.jp/travel/studyabroad/index.htm?p=oA41F201">
				海外行くのに保険は大丈夫ですか？<br/>
				<img src="/office/btn_hoken.jpg" /><br/>
				<p style="font-size:9pt;">AIU保険会社のサイトへジャンプします</p>
			</a>
		</div>
		&nbsp;<br/>
		<div class="cpp-link-block">
			<a target="_blank" href="http://www.jpcashpassport.jp/cpp/lp/mcgin.html?amid=843">
				<img src="/office/btn_cpp.jpg" /><br/>
				お金の新しい持って行き方お教えします
			</a>
		</div>
<?	}	?>


<?
	if (@$_GET['p'] == 'osaka' || @$_GET['p'] == '')	{
?>

		<h2 class="sec-title">大阪会場</h2>
		<div class="top-entry01 event-map">
			<div style="font-size:14pt;">大阪セミナー会場
				<a href="/office/osaka/" style="margin-left:30px;color:navy;font-size:10pt;">大阪オフィスのご案内</a></div>
			<div style="font-size:11pt;">
				○　JR大阪駅より徒歩5分　⇒　詳細は<font color="red"><u><a href="http://www.jawhm.or.jp/blog/osakablog/item/370" target="_blank">こちら</a></u></font>から<br/>
				大阪丸ビル・大阪ヒルトン方面へ南方面へ歩くと大阪駅前第４ビルが見えます。<br/>
				○　地下鉄（徒歩5分）⇒　詳細は<font color="red"><u><a href="http://www.jawhm.or.jp/blog/osakablog/item/366" target="_blank">こちら</a></u></font>から<br/>
				御堂筋線梅田駅、四ツ橋線西梅田駅、谷町線東梅田駅、大阪丸ビル・ヒルトン大阪方面へ<br/>
				○　JR東西線　北新地駅より大阪駅前ビルへ連結　⇒　詳細は<font color="red"><u><a href="http://www.jawhm.or.jp/blog/osakablog/item/368" target="_blank">こちら</a></u></font>から<br/>
				○　阪急電車梅田駅より　大阪丸ビル・ヒルトン大阪方面へ徒歩８分　⇒　詳細は<font color="red"><u><a href="http://www.jawhm.or.jp/blog/osakablog/item/355" target="_blank">こちら</a></u></font>から<br/>
				○　長距離バス　ハービス大阪駅より　ヒルトン大阪方面へ徒歩5分<br/><br/>

				【初めて大阪へお越しのお客様へ】<br/>
				大阪の地下街は大変広く複雑で、大阪にお住まいの方でも道に迷うことが多いです。
				はじめてお越しのお客様は、大阪駅/梅田駅から地上に出てで歩かれたほうがわかりやすいと思います↓<br/>
				大阪駅から「ヒルトンホテル大阪」方向へ向かい→「大阪第４ビル」まで歩いて数分です。<br/>
				<br/>
			当日の連絡先：<br/>
			　大阪市北区梅田1-11-4-500　大阪駅前第4ビル5階 19-1号室<br/>
			　電話：06-6346-3774<br/>
			</div>
			&nbsp;<br/>
			<iframe width="<?php echo $iframe_width;?>" height="<?php echo $iframe_height;?>" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.co.jp/maps?f=q&amp;source=s_q&amp;hl=ja&amp;geocode=&amp;q=%E5%A4%A7%E9%98%AA%E5%B8%82%E5%8C%97%E5%8C%BA%E6%A2%85%E7%94%B01-11-4-500%E3%80%80%E5%A4%A7%E9%98%AA%E9%A7%85%E5%89%8D%E7%AC%AC4%E3%83%93%E3%83%AB5%E9%9A%8E+19-1%E5%8F%B7%E5%AE%A4&amp;aq=&amp;sll=35.673343,139.710388&amp;sspn=0.273878,0.676346&amp;brcurrent=3,0x6000e692f6c597ad:0x229707b075452dc5,0&amp;ie=UTF8&amp;hq=&amp;hnear=%E5%A4%A7%E9%98%AA%E5%BA%9C%E5%A4%A7%E9%98%AA%E5%B8%82%E5%8C%97%E5%8C%BA%E6%A2%85%E7%94%B0%EF%BC%91%E4%B8%81%E7%9B%AE%EF%BC%91%EF%BC%91%E2%88%92%EF%BC%94+%E5%A4%A7%E9%98%AA%E9%A7%85%E5%89%8D%E7%AC%AC%EF%BC%94%E3%83%93%E3%83%AB&amp;ll=34.699897,135.498827&amp;spn=0.008662,0.021136&amp;t=m&amp;z=14&amp;output=embed"></iframe><br /><small><a href="https://maps.google.co.jp/maps?f=q&amp;source=embed&amp;hl=ja&amp;geocode=&amp;q=%E5%A4%A7%E9%98%AA%E5%B8%82%E5%8C%97%E5%8C%BA%E6%A2%85%E7%94%B01-11-4-500%E3%80%80%E5%A4%A7%E9%98%AA%E9%A7%85%E5%89%8D%E7%AC%AC4%E3%83%93%E3%83%AB5%E9%9A%8E+19-1%E5%8F%B7%E5%AE%A4&amp;aq=&amp;sll=35.673343,139.710388&amp;sspn=0.273878,0.676346&amp;brcurrent=3,0x6000e692f6c597ad:0x229707b075452dc5,0&amp;ie=UTF8&amp;hq=&amp;hnear=%E5%A4%A7%E9%98%AA%E5%BA%9C%E5%A4%A7%E9%98%AA%E5%B8%82%E5%8C%97%E5%8C%BA%E6%A2%85%E7%94%B0%EF%BC%91%E4%B8%81%E7%9B%AE%EF%BC%91%EF%BC%91%E2%88%92%EF%BC%94+%E5%A4%A7%E9%98%AA%E9%A7%85%E5%89%8D%E7%AC%AC%EF%BC%94%E3%83%93%E3%83%AB&amp;ll=34.699897,135.498827&amp;spn=0.008662,0.021136&amp;t=m&amp;z=14" style="color:#0000FF;text-align:left">大きな地図で見る</a></small>
		</div>
		&nbsp;<br/>
		<div class="aiu-link-block">
			<a target="_blank" href="http://www.aiu.co.jp/travel/studyabroad/index.htm?p=oA425G01">
				海外行くのに保険は大丈夫ですか？<br/>
				<img src="/office/btn_hoken.jpg" /><br/>
				<p style="font-size:9pt;">AIU保険会社のサイトへジャンプします</p>
			</a>
		</div>
		&nbsp;<br/>
		<div class="cpp-link-block">
			<a target="_blank" href="http://www.jpcashpassport.jp/cpp/lp/mcgin.html?amid=844">
				<img src="/office/btn_cpp.jpg" /><br/>
				お金の新しい持って行き方お教えします
			</a>
		</div>

<?	}	?>


<?
	if (@$_GET['p'] == 'nagoya' || @$_GET['p'] == '')	{
?>

		<h2 class="sec-title">名古屋会場</h2>
		<div class="top-entry01 event-map">
			<div style="font-size:14pt;">名古屋セミナー会場
				<a href="/office/nagoya/" style="margin-left:30px;color:navy;font-size:10pt;">名古屋オフィスのご案内</a></div>
			<div style="font-size:11pt;">
				【JR名古屋駅から徒歩５分】<br />
				桜通口から名駅通りを名古屋ルーセントタワー方向に進んでください。<br />
				地下通路をご利用の場合は、１番または１０番出口がおすすめです。<br />
				旧名古屋中央郵便局（現在は名駅一丁目計画（仮称）により再開発中）の向かい側です。<br />
				より詳細なアクセス方法は<font color="red"><u><a href="http://www.jawhm.or.jp/blog/nagoyablog/item/155" target="_blank">こちら</a></u></font>から。<br/>
				<br/>
				【名古屋駅からの地下通路】<br/>
				名古屋オフィスのビルは、地下通路でお越しいただくことも可能です。<br/>
				１番出口「松岡ビル」を目指してきてください。<br/>
				より詳細なアクセス方法は<font color="red"><u><a href="http://www.jawhm.or.jp/blog/nagoyablog/item/507" target="_blank">こちら</a></u></font>から。<br/>
				<br/>
			当日の連絡先：<br/>
			　名古屋市中村区名駅2-45-19<br/>
			　桑山ビル８階Ａ号室<br/>
			　電話：052-462-1585<br/>
			</div>
			&nbsp;<br/>
			<iframe width="<?php echo $iframe_width;?>" height="<?php echo $iframe_height;?>" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.co.jp/maps?f=q&amp;source=s_q&amp;hl=ja&amp;geocode=&amp;q=%E5%90%8D%E5%8F%A4%E5%B1%8B%E5%B8%82%E4%B8%AD%E6%9D%91%E5%8C%BA%E5%90%8D%E9%A7%852-45-19&amp;aq=&amp;sll=35.17351540482467,136.88285641372204&amp;sspn=0.007656,0.016512&amp;g=%E5%90%8D%E5%8F%A4%E5%B1%8B%E5%B8%82%E4%B8%AD%E6%9D%91%E5%8C%BA%E5%90%8D%E9%A7%852-45-19&amp;brcurrent=3,0x600376c283641057:0x5341f06f138bcbc1,0&amp;ie=UTF8&amp;hq=&amp;hnear=%E6%84%9B%E7%9F%A5%E7%9C%8C%E5%90%8D%E5%8F%A4%E5%B1%8B%E5%B8%82%E4%B8%AD%E6%9D%91%E5%8C%BA%E5%90%8D%E9%A7%85%EF%BC%92%E4%B8%81%E7%9B%AE%EF%BC%94%EF%BC%95%E2%88%92%EF%BC%91%EF%BC%99&amp;ll=35.17351540482467,136.88285641372204&amp;spn=0.001905,0.004128&amp;t=m&amp;z=14&amp;output=embed"></iframe><br /><small><a target="_new" href="https://maps.google.co.jp/maps?f=q&amp;source=embed&amp;hl=ja&amp;geocode=&amp;q=%E5%90%8D%E5%8F%A4%E5%B1%8B%E5%B8%82%E4%B8%AD%E6%9D%91%E5%8C%BA%E5%90%8D%E9%A7%852-45-19&amp;aq=&amp;sll=35.17351540482467,136.88285641372204&amp;sspn=0.007656,0.016512&amp;g=%E5%90%8D%E5%8F%A4%E5%B1%8B%E5%B8%82%E4%B8%AD%E6%9D%91%E5%8C%BA%E5%90%8D%E9%A7%852-45-19&amp;brcurrent=3,0x600376c283641057:0x5341f06f138bcbc1,0&amp;ie=UTF8&amp;hq=&amp;hnear=%E6%84%9B%E7%9F%A5%E7%9C%8C%E5%90%8D%E5%8F%A4%E5%B1%8B%E5%B8%82%E4%B8%AD%E6%9D%91%E5%8C%BA%E5%90%8D%E9%A7%85%EF%BC%92%E4%B8%81%E7%9B%AE%EF%BC%94%EF%BC%95%E2%88%92%EF%BC%91%EF%BC%99&amp;ll=35.17351540482467,136.88285641372204&amp;spn=0.001905,0.004128&amp;t=m&amp;z=14" style="color:#0000FF;text-align:left">大きな地図で見る</a></small>
		</div>
		&nbsp;<br/>
		<div class="aiu-link-block">
			<a target="_blank" href="http://www.aiu.co.jp/travel/studyabroad/index.htm?p=oA41F201">
				海外行くのに保険は大丈夫ですか？<br/>
				<img src="/office/btn_hoken.jpg" /><br/>
				<p style="font-size:9pt;">AIU保険会社のサイトへジャンプします</p>
			</a>
		</div>
		&nbsp;<br/>
		<div class="cpp-link-block">
			<a target="_blank" href="http://www.jpcashpassport.jp/cpp/lp/mcgin.html?amid=847">
				<img src="/office/btn_cpp.jpg" /><br/>
				お金の新しい持って行き方お教えします
			</a>
		</div>

<?	}	?>


<?
	if (@$_GET['p'] == 'fukuoka' || @$_GET['p'] == '')	{
?>

		<h2 class="sec-title">福岡会場</h2>
		<div class="top-entry01 event-map">
			<div style="font-size:14pt;">福岡セミナー会場
				<a href="/office/fukuoka/" style="margin-left:30px;color:navy;font-size:10pt;">福岡オフィスのご案内</a>
			</div>
			<div style="font-size:12pt; color:red; text-weight:bold; margin:5px 10px 5px 10px;padding:5px 20px 5px 20px; border:dotted red 1px;">
				【ご注意】<br/>
				２０１３年６月８日（土曜日）よりセミナーの会場が変更となります。<br/>
				ご来場の際には、ご注意ください。<br/>
			</div>
			<div style="font-size:11pt;">
			【JR天神駅から徒歩8分】<br/>
			駅から　天神駅南口　まっすぐ渡辺通りを薬院方面へ下る(南方面）<br/>
			ロフトを通り超え最初の1個目の信号をわたって最初の茶緑色の星野ビル６階です。<br/>
			【JR天神駅から】　⇒　詳細は<font color="red"><u><a href="http://www.jawhm.or.jp/blog/fukuokablog/item/321" target="_blank">こちら</a></u></font>から<br/>
			【西鉄薬院駅から】　⇒　詳細は<font color="red"><u><a href="http://www.jawhm.or.jp/blog/fukuokablog/item/485" target="_blank">こちら</a></u></font>から<br/>
			<br/>
			<div style="font-size:11pt;">
			【２０１３年６月８日（土曜日）より】<br/>
			　　日本ワーキングホリデー協会　福岡オフィス<br/>
			　　福岡市中央区渡辺通4-6-20　星野ビル6階1号室<br/>
			　　当日の連絡先：03-6304-5858<br/>
			</div>
			&nbsp;<br/>
			<iframe width="<?php echo $iframe_width;?>" height="<?php echo $iframe_height;?>" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.co.jp/maps?f=q&amp;source=s_q&amp;hl=ja&amp;geocode=&amp;q=%E7%A6%8F%E5%B2%A1%E5%B8%82%E4%B8%AD%E5%A4%AE%E5%8C%BA%E6%B8%A1%E8%BE%BA%E9%80%9A4-6-20&amp;aq=&amp;sll=35.673343,139.710388&amp;sspn=0.406634,0.783463&amp;brcurrent=3,0x3541919a93d1de61:0x944c832c365be3a0,0,0x3541919a8de917d1:0xf61becc141145e9c&amp;ie=UTF8&amp;hq=&amp;hnear=%E7%A6%8F%E5%B2%A1%E7%9C%8C%E7%A6%8F%E5%B2%A1%E5%B8%82%E4%B8%AD%E5%A4%AE%E5%8C%BA%E6%B8%A1%E8%BE%BA%E9%80%9A%EF%BC%94%E4%B8%81%E7%9B%AE%EF%BC%96%E2%88%92%EF%BC%92%EF%BC%90&amp;t=m&amp;z=14&amp;ll=33.586011,130.40241&amp;output=embed"></iframe><br /><small><a href="https://maps.google.co.jp/maps?f=q&amp;source=embed&amp;hl=ja&amp;geocode=&amp;q=%E7%A6%8F%E5%B2%A1%E5%B8%82%E4%B8%AD%E5%A4%AE%E5%8C%BA%E6%B8%A1%E8%BE%BA%E9%80%9A4-6-20&amp;aq=&amp;sll=35.673343,139.710388&amp;sspn=0.406634,0.783463&amp;brcurrent=3,0x3541919a93d1de61:0x944c832c365be3a0,0,0x3541919a8de917d1:0xf61becc141145e9c&amp;ie=UTF8&amp;hq=&amp;hnear=%E7%A6%8F%E5%B2%A1%E7%9C%8C%E7%A6%8F%E5%B2%A1%E5%B8%82%E4%B8%AD%E5%A4%AE%E5%8C%BA%E6%B8%A1%E8%BE%BA%E9%80%9A%EF%BC%94%E4%B8%81%E7%9B%AE%EF%BC%96%E2%88%92%EF%BC%92%EF%BC%90&amp;t=m&amp;z=14&amp;ll=33.586011,130.40241" style="color:#0000FF;text-align:left">大きな地図で見る</a></small>
			<div style="font-size:11pt; margin-top:15px;">
			　　【２０１３年６月７日（金曜日）まで】<br/>
			　　　　CafeBar Manly　マンリーカフェ<br/>
			　　　　カフェ内にて開催します。<br/>
			　　　　福岡県福岡市中央区今泉1‐18‐55<br/>
			　　　　<a href="http://www.hotpepper.jp/strJ000761870/" target="_blank">http://www.hotpepper.jp/strJ000761870/</a><br/>
			　　　　当日の連絡先：03-6304-5858<br/>
			</div>
			&nbsp;<br/>
			<iframe width="<?php echo $iframe_width;?>" height="<?php echo $iframe_height;?>" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://www.google.co.jp/maps?f=q&amp;source=s_q&amp;hl=ja&amp;geocode=&amp;q=%E7%A6%8F%E5%B2%A1%E7%9C%8C%E7%A6%8F%E5%B2%A1%E5%B8%82%E4%B8%AD%E5%A4%AE%E5%8C%BA%E4%BB%8A%E6%B3%891%E2%80%9018%E2%80%9055&amp;aq=&amp;sll=33.588254,130.398928&amp;sspn=0.01228,0.015492&amp;brcurrent=3,0x35419184ecdc54dd:0xceb5791848afad89,0,0x35419184f4c9ca99:0xa5ae37e483390143&amp;ie=UTF8&amp;hq=&amp;hnear=%E7%A6%8F%E5%B2%A1%E7%9C%8C%E7%A6%8F%E5%B2%A1%E5%B8%82%E4%B8%AD%E5%A4%AE%E5%8C%BA%E4%BB%8A%E6%B3%89%EF%BC%91%E4%B8%81%E7%9B%AE%EF%BC%91%EF%BC%98%E2%88%92%EF%BC%95%EF%BC%95&amp;ll=33.588454,130.39896&amp;spn=0.02145,0.051413&amp;z=14&amp;iwloc=A&amp;output=embed"></iframe><br /><small><a target="_new" href="http://www.google.co.jp/maps?f=q&amp;source=embed&amp;hl=ja&amp;geocode=&amp;q=%E7%A6%8F%E5%B2%A1%E7%9C%8C%E7%A6%8F%E5%B2%A1%E5%B8%82%E4%B8%AD%E5%A4%AE%E5%8C%BA%E4%BB%8A%E6%B3%891%E2%80%9018%E2%80%9055&amp;aq=&amp;sll=33.588254,130.398928&amp;sspn=0.01228,0.015492&amp;brcurrent=3,0x35419184ecdc54dd:0xceb5791848afad89,0,0x35419184f4c9ca99:0xa5ae37e483390143&amp;ie=UTF8&amp;hq=&amp;hnear=%E7%A6%8F%E5%B2%A1%E7%9C%8C%E7%A6%8F%E5%B2%A1%E5%B8%82%E4%B8%AD%E5%A4%AE%E5%8C%BA%E4%BB%8A%E6%B3%89%EF%BC%91%E4%B8%81%E7%9B%AE%EF%BC%91%EF%BC%98%E2%88%92%EF%BC%95%EF%BC%95&amp;ll=33.588454,130.39896&amp;spn=0.02145,0.051413&amp;z=14&amp;iwloc=A" style="color:#0000FF;text-align:left" target="_blank">大きな地図で見る</a></small>
		</div>
		&nbsp;<br/>
		<div class="aiu-link-block">
			<a target="_blank" href="http://www.aiu.co.jp/travel/studyabroad/index.htm?p=oA425H01">
				海外行くのに保険は大丈夫ですか？<br/>
				<img src="/office/btn_hoken.jpg" /><br/>
				<p style="font-size:9pt;">AIU保険会社のサイトへジャンプします</p>
			</a>
		</div>
		&nbsp;<br/>
		<div class="cpp-link-block">
			<a target="_blank" href="http://www.jpcashpassport.jp/cpp/lp/mcgin.html?amid=845">
				<img src="/office/btn_cpp.jpg" /><br/>
				お金の新しい持って行き方お教えします
			</a>
		</div>

<?	}	?>


<?
	if (@$_GET['p'] == 'okinawa' || @$_GET['p'] == '')	{
?>

		<h2 class="sec-title">沖縄会場</h2>
		<div class="top-entry01 event-map">
			<div style="font-size:14pt;">沖縄セミナー会場
				<a href="/office/okinawa/" style="margin-left:30px;color:navy;font-size:10pt;">沖縄オフィスのご案内</a></div>
			<div style="font-size:11pt;">
			　　ｅ－ｓａ（イーサ）<br/>
			　　沖縄県浦添市宮城２－３９－５ 花水木ビル１F<br/>
			　　当日の連絡先：098-927-5388<br/>
			　　<strong>※駐車場はございませんので、公共交通機関を利用してお越しください。</strong><br/>
			</div>
			&nbsp;<br/>
			<iframe width="<?php echo $iframe_width;?>" height="<?php echo $iframe_height;?>" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.co.jp/maps?f=q&amp;source=s_q&amp;hl=ja&amp;geocode=+&amp;q=%E6%B2%96%E7%B8%84%E7%9C%8C%E6%B5%A6%E6%B7%BB%E5%B8%82%E5%AE%AE%E5%9F%8E%EF%BC%92%E2%88%92%EF%BC%93%EF%BC%99%E2%88%92%EF%BC%95+%E8%8A%B1%E6%B0%B4%E6%9C%A8%E3%83%93%E3%83%AB%EF%BC%91F&amp;g=%E3%80%92901-2126+%E6%B2%96%E7%B8%84%E7%9C%8C%E6%B5%A6%E6%B7%BB%E5%B8%82+2%E4%B8%81%E7%9B%AE39-5+%E8%8A%B1%E6%B0%B4%E6%9C%A8%E3%83%93%E3%83%AB1F&amp;brcurrent=3,0x34e56b9711f3acef:0x100b98c92deca54f,0&amp;ie=UTF8&amp;hq=%E8%8A%B1%E6%B0%B4%E6%9C%A8%E3%83%93%E3%83%AB%EF%BC%91F&amp;hnear=%E6%B2%96%E7%B8%84%E7%9C%8C%E6%B5%A6%E6%B7%BB%E5%B8%82%E5%AE%AE%E5%9F%8E%EF%BC%92%E4%B8%81%E7%9B%AE%EF%BC%93%EF%BC%99%E2%88%92%EF%BC%95&amp;t=m&amp;vpsrc=6&amp;ll=26.249506,127.701902&amp;spn=0.013856,0.023561&amp;z=15&amp;iwloc=A&amp;output=embed"></iframe><br /><small><a target="_new" href="http://maps.google.co.jp/maps?f=q&amp;source=embed&amp;hl=ja&amp;geocode=+&amp;q=%E6%B2%96%E7%B8%84%E7%9C%8C%E6%B5%A6%E6%B7%BB%E5%B8%82%E5%AE%AE%E5%9F%8E%EF%BC%92%E2%88%92%EF%BC%93%EF%BC%99%E2%88%92%EF%BC%95+%E8%8A%B1%E6%B0%B4%E6%9C%A8%E3%83%93%E3%83%AB%EF%BC%91F&amp;g=%E3%80%92901-2126+%E6%B2%96%E7%B8%84%E7%9C%8C%E6%B5%A6%E6%B7%BB%E5%B8%82+2%E4%B8%81%E7%9B%AE39-5+%E8%8A%B1%E6%B0%B4%E6%9C%A8%E3%83%93%E3%83%AB1F&amp;brcurrent=3,0x34e56b9711f3acef:0x100b98c92deca54f,0&amp;ie=UTF8&amp;hq=%E8%8A%B1%E6%B0%B4%E6%9C%A8%E3%83%93%E3%83%AB%EF%BC%91F&amp;hnear=%E6%B2%96%E7%B8%84%E7%9C%8C%E6%B5%A6%E6%B7%BB%E5%B8%82%E5%AE%AE%E5%9F%8E%EF%BC%92%E4%B8%81%E7%9B%AE%EF%BC%93%EF%BC%99%E2%88%92%EF%BC%95&amp;t=m&amp;vpsrc=6&amp;ll=26.249506,127.701902&amp;spn=0.013856,0.023561&amp;z=15&amp;iwloc=A" style="color:#0000FF;text-align:left">大きな地図で見る</a></small>
		</div>
		&nbsp;<br/>
		<div class="aiu-link-block">
			<a target="_blank" href="http://www.aiu.co.jp/travel/studyabroad/index.htm?p=oA41F201">
				海外行くのに保険は大丈夫ですか？<br/>
				<img src="/office/btn_hoken.jpg" /><br/>
				<p style="font-size:9pt;">AIU保険会社のサイトへジャンプします</p>
			</a>
		</div>
		&nbsp;<br/>
		<div class="cpp-link-block">
			<a target="_blank" href="http://www.jpcashpassport.jp/cpp/lp/mcgin.html?amid=846">
				<img src="/office/btn_cpp.jpg" /><br/>
				お金の新しい持って行き方お教えします
			</a>
		</div>
<?	}	?>

	</div><!--top-mainEND-->
	</div><!--maincontentEND-->

  </div><!--contentsEND-->
  </div><!--contentsboxEND-->
	<?php fncMenuFooter('nolink'); ?>
</body>
</html>