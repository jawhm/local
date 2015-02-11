<?php
require_once 'include/header.php';
require_once 'seminar/include/kouen_function.php';

$header_obj = new Header();

$header_obj->fncFacebookMeta_function=true;

$header_obj->title_page='留学・ワーホリ講演セミナー';
$header_obj->description_page='ワーキングホリデー（ワーホリ）協定国の最新のビザ取得方法や渡航情報などを発信しています。また、ワーキングホリデー（ワーホリ）をされる方向けの各種無料セミナーを開催しています。オーストラリア、ニュージーランド、カナダ、韓国、フランス、ドイツ、イギリス、アイルランド、デンマーク、台湾、香港でワーキングホリデー（ワーホリ）ビザの取得が可能です。ワーキングホリデー（ワーホリ）ビザ以外に学生ビザでの留学などもお手伝い可能です。';

$header_obj->add_style='<style>
.panel{
	cursor: pointer;
	position:relative;
	background-color:white;
	filter: alpha(opacity=100);
	  -moz-opacity:100;
	  opacity:100;
}
.list{
	display:none;
	text-align:left;	
}
</style>
';

$header_obj->add_js_files='<script type="text/javascript" src="/js/jquery.blockUI.js"></script>
<script type="text/javascript" src="js/jquery.corner.js"></script>
<script type="text/javascript">
jQuery(function($) {
	jQuery(".open").click(function(){
		jQuery(this).parent().children(".det").slideToggle("slow");
		//jQuery(this).slideToggle("hide");
	});
	jQuery(".openlist").click(function(){
		jQuery(this).parent().children(".list").slideToggle("slow");
		//jQuery(this).slideToggle("hide");
	});

});
</script>
<script>
$(function () {
	$(".chiiki").corner();
	// イベント設定
	var obj = document.getElementsByTagName("span");
	for (idx=0; idx<obj.length; idx++)	{
		if (obj[idx].className == "panel")	{
			obj[idx].onmouseover = fncover;
			obj[idx].onmouseout = fncout;
			obj[idx].onclick = fncclick;
		}
		if (obj[idx].className == "chiiki")	{
			obj[idx].onclick = fncclick;
		}
	}
});
function fncover()	{
	var id = this.getAttribute("id");
	jQuery("#"+id).css({ opacity: "0.65" });
}
function fncout()	{
	var id = this.getAttribute("id");
	jQuery("#"+id).css({ opacity: "1" });
}
function fncclick()	{
	var id = this.getAttribute("id");
	location.href = "/seminar/ser/kouen/"+id;
}
function fnc_yoyaku(obj)	{
	document.getElementById("btn_soushin").disabled = false;
	document.getElementById("btn_soushin").value = "送信";
	document.getElementById("div_wait").style.display = "none";
	document.getElementById("form_title").innerHTML = obj.getAttribute("title");
	document.getElementById("txt_title").value = obj.getAttribute("title");
	document.getElementById("txt_id").value = obj.getAttribute("uid");
	$.blockUI({ message: $("#yoyakuform"),
	css: { 
		top:  ($(window).height() - 400) /2 + "px", 
		left: ($(window).width() - 600) /2 + "px", 
		width: "600px" 
	}
 }); 
}
function btn_cancel()	{
	$.unblockUI();
}
function btn_submit()	{
	obj = document.getElementById("txt_name");
	if (obj.value == "")	{
		alert("お名前（氏）を入力してください。");
		obj.focus();
		return false;
	}
	obj = document.getElementById("txt_name2");
	if (obj.value == "")	{
		alert("お名前（名）を入力してください。");
		obj.focus();
		return false;
	}
	obj = document.getElementById("txt_furigana");
	if (obj.value == "")	{
		alert("フリガナ（氏）を入力してください。");
		obj.focus();
		return false;
	}
	obj = document.getElementById("txt_furigana2");
	if (obj.value == "")	{
		alert("フリガナ（名）を入力してください。");
		obj.focus();
		return false;
	}
	obj = document.getElementById("txt_mail");
	if (obj.value == "")	{
		alert("メールアドレスを入力してください。");
		obj.focus();
		return false;
	}
	obj = document.getElementById("txt_tel");
	if (obj.value == "")	{
		alert("電話番号を入力してください。");
		obj.focus();
		return false;
	}

	if (!confirm("ご入力頂いた内容を送信します。よろしいですか？"))	{
		return false;
	}

	$senddata = $("form").serialize();

	document.getElementById("div_wait").style.display = "";

	document.getElementById("btn_soushin").value = "処理中...";
	document.getElementById("btn_soushin").disabled = true;

	$.ajax({
		type: "POST",
		url: "../yoyaku/yoyaku.php",
		data: $senddata,
		success: function(msg){
			document.getElementById("div_wait").style.display = "none";
			alert(msg);
			$.unblockUI();
		},
		error:function(){
			alert("通信エラーが発生しました。");
			$.unblockUI();
		}
	});
}
</script>
';

$header_obj->fncMenuHead_imghtml = '<img id="top-mainimg" src="images/top-mainimg.jpg" alt="" width="970" height="170" />';
$header_obj->fncMenuHead_h1text = '日本ワーキングホリデー協会の講演セミナー情報';

$header_obj->display_header();

?>
	<div id="maincontent">
		<?php echo $header_obj->breadcrumbs(); ?>
		<br />
<div align="center">


		<p><img src="images/2013winter/mainimage.png" title="２０１３年留学＆ワーホリ初夢セミナー"/></p>
		<p><img src="images/2013winter/line.png" title="２０１３年留学＆ワーホリ初夢セミナー" style="margin-bottom:10px;" /></p>
		<table background="images/2013winter/back.png" width="661">  
		<tr>
		<td><div align="center">
		 		 <img src="images/2013winter/seminar.png" title="２０１３年留学＆ワーホリ初夢セミナー"/><a href="#0113"><img src="images/2013winter/0113_off.png" title="２０１３年留学＆ワーホリ初夢セミナー"/></a>	<br/>
		 <a href="#0107"><img src="images/2013winter/0107_off.png" title="２０１３年留学＆ワーホリ初夢セミナー"/></a>		 <a href="#0108"><img src="images/2013winter/0108_off.png" title="２０１３年留学＆ワーホリ初夢セミナー"/></a><br />
		 <a href="#0110"><img src="images/2013winter/0110_off.png" title="２０１３年留学＆ワーホリ初夢セミナー"/></a>		 <a href="#0111"><img src="images/2013winter/0111_off.png" title="２０１３年留学＆ワーホリ初夢セミナー"/></a><br />
		</div>
		</tr>
		</td>
		</table>




<!--
		<table background="images/2013winter/back.png">  
		<tr>
		<td>
		<img src="images/2013winter/seminar.png" title="２０１３年留学＆ワーホリ初夢セミナー"/><br />
		<br />

       	     <a href="#nagoya"><img src="images/2013winter/0107_off.png" title="２０１３年留学＆ワーホリ初夢セミナー"/></a><br />
		<br />
       	     <a href="#nagoya"><img src="images/2013winter/0110_off.png" title="２０１３年留学＆ワーホリ初夢セミナー"/></a><br />
		<br />
		<br />

		</td>

		<td>
       	     <a href="#nagoya"><img src="images/2013winter/0113_off.png" title="２０１３年留学＆ワーホリ初夢セミナー"/></a><br />
		<br />

       	     <a href="#nagoya"><img src="images/2013winter/0108_off.png" title="２０１３年留学＆ワーホリ初夢セミナー"/></a><br />
       	     <a href="#nagoya"><img src="images/2013winter/0111_off.png" title="２０１３年留学＆ワーホリ初夢セミナー"/></a><br />

		</td>
		</tr>
		</table>
<br />-->
<br /><br />
		<p><img src="images/2013winter/line.png" title="２０１３年留学＆ワーホリ初夢セミナー" style="margin-bottom:20px;" /></p>

		<p><img src="images/2013winter/0113_t.png" title="２０１３年留学＆ワーホリ初夢セミナー" style="margin-bottom:15px;" id="0113" /></p>

	<table width="650px">	
		<tr>
			<td>
		<img src="images/2013winter/0113.png" title="２０１３年留学＆ワーホリ初夢セミナー"/>
			</td>
			<td>
            <font size="2" color="#333333">
			「留学・ワーホリを通じて夢を叶える！」とても素晴らしいことです。<br />
<br />
			では、留学・ワーホリは夢がないとしてはいけないものなのでしょうか？留学・ワーホリを
			通じて夢を見つける、自分らしい生き方を模索することも一つの選択肢だと思います。<br />
<br />
			私の夢はプロ野球選手になることでした。その夢は18歳の夏に甲子園に出場し、あと
			少しというところで腰を負傷し、一瞬で叶わぬものとなりました。でも夢がなくなった
			ことがきっかけで留学という新しい未知のモノに飛び込むことになり、日本では考えも
			しなかった体験や出会いを通じ、今は自分らしい生き方をしています。<br />
<br />
			このセミナーでは留学経験（学校、ホームステイ、ルームシェアや少年野球のコーチ経験、
			ちょっとしたトラブルや恋愛経験？）を通じて、どのように現在5カ国で仕事をするまでに
			なったのかをご紹介します。        </p>
<br />
			</td>
		</tr>
	</table>
        <div class="chiiki-box">
        	<span class="chiiki<?php if($header_obj->computer_use()) echo' openlist'; ?>" id="0113seminar">
       			>> この講演会のスケジュール・ご予約はこちら
        	</span>
            <div class="list">
				<?php
					$data = get_list('0113seminar');
					display_list($data);
				?>
            </div>
        </div>
<br /><br />


		<p><img src="images/2013winter/line.png" title="２０１３年留学＆ワーホリ初夢セミナー" style="margin-bottom:20px;" /></p>

		<p><img src="images/2013winter/0107_t.png" title="２０１３年留学＆ワーホリ初夢セミナー" style="margin-bottom:15px;"  id="0107" /></p>

	<table width="650px">	
		<tr>
			<td>
		<img src="images/2013winter/0107.png" title="２０１３年留学＆ワーホリ初夢セミナー"/>
			</td>
			<td>
            <font size="2" color="#333333">
            　初めての海外は高校1年の時オーストラリアメルボルンでした。
		その経験もあり、就職した会社が国際支店海外営業部。
		英語が飛び交う環境の中で英語を使えるようになりたいと思い
		5年働いた会社を辞めオーストラリアのワーキングホリデーで2年間過ごしました。<br />
<br />
		体験としては語学学校、ラウンド、ファーム、ダイビング、仕事経験。<br />
<br />
		海外に行くと決めた方、行くか行かないか悩んでいる方、興味はあるが、心配と不安が多い方へ行ったからこそ、
		見れた物、感じた事、出会えた仲間、トラブルをどう対処したか、
		初めて体験したホームシック等のお話しも踏まえながら、伝えたいメッセージも含めてお話しさせて頂きます。
		体験談セミナーで皆様にお会い出来るのを楽しみにしております。<br />
        </p>
<br />
        <br />        
			</td>
		</tr>
	</table>
        <div class="chiiki-box">
        	<span class="chiiki<?php if($header_obj->computer_use()) echo' openlist'; ?>" id="0107seminar">
       			>> この講演会のスケジュール・ご予約はこちら
        	</span>
            <div class="list">
				<?php
					$data = get_list('0107seminar');
					display_list($data);
				?>
            </div>
        </div>
<br /><br />

		<p><img src="images/2013winter/line.png" title="２０１３年留学＆ワーホリ初夢セミナー" style="margin-bottom:20px;" /></p>

		<p><img src="images/2013winter/0108_t.png" title="２０１３年留学＆ワーホリ初夢セミナー" style="margin-bottom:15px;" id="0108"/></p>

	<table width="650px">	
		<tr>
			<td>
		<img src="images/2013winter/0108.png" title="２０１３年留学＆ワーホリ初夢セミナー"/>
			</td>
			<td>
            <font size="2" color="#333333">
            

　”いつかフランスに行く！”
思えば、中学生のころからの口癖でした。
最初は環境への憧れから入ったフランスへの渡航希望でしたが、、
関連する好きなモノが増えるに連れて”目標”に変わっていったのです。<br />
<br />

　趣味が高じて学生時代にフランス映画の研究をしてからは、
日本から得られる情報の限界を感じて渡航を決意。
渡航当初は、
大好きな文化のある国に滞在していることに満足をしておりました。
不思議なことですが、
文化や芸術をつくるのは人間なのに、渡航までは現地の人間に興味が全くなかった。<br />
<br />

　しかし、滞在をしてからは”Bonjour！”を言うのが精いっぱい。

友達を作ろうとしても意思をうまく伝えられずにもどかしい思いばかり。


そこで必死にコミュニケーションをとり、

初めてできた友人に”あなたに会えてよかった”を伝えられた時、

確かに気持ちが通じた感動を覚えています。

どこにいても人間関係の大切さや温かさを感じた瞬間でした。<br />

<br />

　仕事経験や語学力の上達など人生に役立つものを得ることもできます。

しかし、人生の豊かするものとして、日本では得られない大切なことを学ぶこともできるのです。


わたしの渡仏経験が、
皆様の背中を押す手助けとなると幸いです。

ぜひ、お待ちしております。

        </p>	<br />	</td>
		</tr>
		</table>
        <div class="chiiki-box">
        	<span class="chiiki<?php if($header_obj->computer_use()) echo' openlist'; ?>" id="0108seminar">
       			>> この講演会のスケジュール・ご予約はこちら
        	</span>
            <div class="list">
				<?php
					$data = get_list('0108seminar');
					display_list($data);
				?>
            </div>
        </div>
<br /><br />



		<p><img src="images/2013winter/line.png" title="２０１３年留学＆ワーホリ初夢セミナー" style="margin-bottom:20px;" /></p>

		<p><img src="images/2013winter/0110_t.png" title="２０１３年留学＆ワーホリ初夢セミナー" style="margin-bottom:15px;" id="0110"/></p>

	<table width="650px">	
		<tr>
			<td>
		<img src="images/2013winter/0110.png" title="２０１３年留学＆ワーホリ初夢セミナー"/>
			</td>
			<td>
            <font size="2" color="#333333">

			学生の今、やりたいこと、叶えたいことは何ですか？<br />
<br />
			高校生の頃から一度は留学したいという思いを抱きながらも
			なかなか踏み出せず、でも英語を話せるようになりたいという気持ちは強まり
			高校卒業後に外国語の専門学校へ進学しました。
			そのまま就職し、留学という夢からは遠ざかってしまいましたが、
			あきらめきれず、最終的には退職し、ワーキングホリデーでその想いを実現させました。<br />
<br />
			せっかく行ったのだから、何か英語の資格が欲しいと思い
			IELTSという英語検定のコースに入り、現地で受験しました。<br />
<br />

			休学して留学？
			卒業後の留学？
			それとも一度社会に出てから…？<br />

<br />			やりたいことがあるのに、どうしたらいいかわからない。
			海外には行きたいけれど、いつ行けばいいのか分からない。

			体験談とともに、皆さんの疑問を少しでも解消し、
			夢のための答えを見つけていただける時間になればと思います。        </p>
       <br />
			</td>
		</tr>
	</table>
        <div class="chiiki-box">
        	<span class="chiiki<?php if($header_obj->computer_use()) echo' openlist'; ?>" id="0110seminar">
       			>> この講演会のスケジュール・ご予約はこちら
        	</span>
            <div class="list">
				<?php
					$data = get_list('0110seminar');
					display_list($data);
				?>
            </div>
        </div>
<br /><br />



		<p><img src="images/2013winter/line.png" title="２０１３年留学＆ワーホリ初夢セミナー" style="margin-bottom:20px;" /></p>

		<p><img src="images/2013winter/0111_t.png" title="２０１３年留学＆ワーホリ初夢セミナー" style="margin-bottom:15px;" id="0111" /></p>

	<table width="650px">	
		<tr>
			<td>
		<img src="images/2013winter/0111.png" title="２０１３年留学＆ワーホリ初夢セミナー"/>
			</td>
			<td>
            <font size="2" color="#333333">
			初一人旅、初海外、すべてが初めての体験。　１６歳の時に、海外に行き、日本では経験できない事をたくさんしました。
			英語がまったくできない私が、半年後には現地のハイスクールに!!!<br />
<br />
			最初は自分の殻にこもり、友達が出来なくて一人でさびしくランチを食べていた日々。。
			それは、自分が悪いと気付かされたとき、ある方法によって友達がどんどんできました！<br />
<br />
			英語はできなくてもいいんです！　渡航してから学びましょう！
			英語の伸ばし方や、私が経験した事、ホームステイの事に関して、
			そして友達の作り方をお話させて頂きます!!<br />
<br />
			長期で学校に行きたい方！高校や大学に行きたい方！
			ワーキングホリデービザで悩んでいる方！
			ともに経験した、私からアドバイスを!!
			１人１人にあった、お話が出来たらと思います！

			当日はお話を出来るのを楽しみにしております。        </p>
<br />
			</td>
		</tr>
	</table>
	</table>
        <div class="chiiki-box">
        	<span class="chiiki<?php if($header_obj->computer_use()) echo' openlist'; ?>" id="0111seminar">
       			>> この講演会のスケジュール・ご予約はこちら
        	</span>
            <div class="list">
				<?php
					$data = get_list('0111seminar');
					display_list($data);
				?>
            </div>
        </div>
<br /><br />


		<p><img src="images/2013winter/line.png" title="２０１３年留学＆ワーホリ初夢セミナー" style="margin-bottom:20px;" /></p>



	               </div>	 


        <div style="border: 2px dotted deepskyblue; margin: 10px 0 10px 0; padding: 5px 10px 5px 10px; font-size:12pt;">
            興味のあるセミナーを上から選んで下さい。詳細がここにでます。
            <div style="font-size:13pt;"><a href="../seminar.html">通常セミナーはこちら</a></div>
        </div>
        
        <div style="border: 2px dotted navy; margin: 30px 0 30px 0; padding: 5px 10px 5px 10px; font-size:10pt;">
            【ご注意：スマートフォンをご利用の方へ】<br/>
            スマートフォンなど、ＰＣ以外のブラウザからご利用された場合、予約フォームが正しく機能しない場合があります。<br/>
            この場合、お手数ですが、以下の内容を toiawase@jawhm.or.jp までご連絡ください。<br/>
            　・　参加希望のイベントの会場名、日程<br/>
            　・　お名前<br/>
            　・　当日連絡の付く電話番号<br/>
            　・　興味のある国<br/>
            　・　出発予定時期<br/>
        </div>

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
	<?php
		if($header_obj->computer_use()) //only for pc
		{ ?>

        <div id="yoyakuform" style="display:none; margin:15px 20px 15px 20px; font-size:10pt; cursor:default;">
            <div style="font-size:12pt; font-weight:bold; margin:0 0 8px 0;">イベント　予約フォーム</div>
        
            <form name="form_yoyaku">
            <table style="width:560px;">
                <tr style="background-color:lightblue;">
                    <td nowrap style="text-align:right;">イベント名&nbsp;</td>
                    <td id="form_title" style="text-align:left;"></td>
                    <input type="hidden" name="セミナー名" id="txt_title" value="">
                    <input type="hidden" name="セミナー番号" id="txt_id" value="">
                </tr>
                <tr>
                    <td nowrap style="border-bottom: 1px dotted pink; text-align:right;">お名前&nbsp;</td>
                    <td style="border-bottom: 1px dotted pink; text-align:left;">
                        (氏)<input type="text" name="お名前" id="txt_name" value="" size=10>
                        (名)<input type="text" name="お名前2" id="txt_name2" value="" size=10>
                    </td>
                </tr>
                <tr>
                    <td nowrap style="border-bottom: 1px dotted pink; text-align:right;">フリガナ&nbsp;</td>
                    <td style="border-bottom: 1px dotted pink; text-align:left;">
                        (氏)<input type="text" name="フリガナ" id="txt_furigana" value="" size=10>
                        (名)<input type="text" name="フリガナ2" id="txt_furigana2" value="" size=10>
                    </td>
                </tr>
                <tr style="background-color:white;">
                    <td nowrap valign="top" style="border-bottom: 1px dotted pink; text-align:right;">メールアドレス&nbsp;</td>
                    <td style="border-bottom: 1px dotted pink; text-align:left;">
                        <input type="text" name="メール" id="txt_mail" value="" size=40><br/>
                        <span style="font-size:8pt;">
                        ※予約確認のメールをお送りします。必ず有効なアドレスを入力してください。<br/>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td nowrap style="border-bottom: 1px dotted pink; text-align:right;">当日連絡の付く電話番号&nbsp;</td>
                    <td style="border-bottom: 1px dotted pink; text-align:left;"><input type="text" name="電話番号" id="txt_tel" value="" size=20></td>
                </tr>
                <tr style="background-color:white;">
                    <td nowrap style="border-bottom: 1px dotted pink; text-align:right;">興味のある国&nbsp;</td>
                    <td style="border-bottom: 1px dotted pink; text-align:left;"><input type="text" name="興味国" id="txt_kuni" value="" size=50></td>
                </tr>
                <tr>
                    <td nowrap style="border-bottom: 1px dotted pink; text-align:right;">出発予定時期&nbsp;</td>
                    <td style="border-bottom: 1px dotted pink; text-align:left;"><input type="text" name="出発時期" id="txt_jiki" value="" size=50></td>
                </tr>
                <tr>
                    <td nowrap valign="top" style="border-bottom: 1px dotted pink; text-align:right;">同伴者有無&nbsp;</td>
                    <td style="border-bottom: 1px dotted pink; text-align:left;">
                        <input type="checkbox" name="同伴者" id="txt_dohan"> 同伴者あり<br/>
                        <span style="font-size:8pt;">
                        　　※同伴者ありの場合、２人分の席を確保致します。<br/>
                        　　※３名以上でご参加の場合は、メールにてご連絡ください。<br/>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td nowrap style="border-bottom: 1px dotted pink; text-align:right;">今後のご案内&nbsp;</td>
                    <td style="border-bottom: 1px dotted pink; text-align:left;"><input type="checkbox" name="メール会員" id="txt_mailmem" checked> このメールアドレスをメール会員(無料)に登録する</td>
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
        
            <input type="button" class="button_cancel" value=" 取消 " onclick="btn_cancel();">　　　　　
            <input type="button" class="button_submit" value=" 送信 " id="btn_soushin" onclick="btn_submit();">
        </div>
	<?php
		} ?>
        
	</div><!--main content-->
<!--	</div>-->  
  </div>
  </div>
	<?php fncMenuFooter($header_obj->footer_type); ?>
</body>
</html>