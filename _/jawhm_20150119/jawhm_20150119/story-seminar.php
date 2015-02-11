<?php
require_once 'include/header.php';
require_once 'seminar/include/kouen_function.php';

$header_obj = new Header();

$header_obj->fncFacebookMeta_function=true;

$header_obj->title_page='留学・ワーホリ体験談セミナー';
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

$header_obj->fncMenuHead_imghtml = '<img id="top-mainimg" src="images/mainimg/top-mainimg.jpg" alt="" alt="" width="970" height="170" />';
$header_obj->fncMenuHead_h1text = '日本ワーキングホリデー協会の体験談セミナー情報';

$header_obj->display_header();

?>
	<div id="maincontent">
		<?php echo $header_obj->breadcrumbs(); ?>
		<br />

		<h2 class="sec-title-story" style="margin-bottom:15px;">体験談セミナーとは？</h2>
<p class="text01">

<img src="images/kouen/story.jpg" alt="" style="float:left;"/>
<br />
　　既にワーキングホリデーや留学を経験した方の<br />
　　体験談や失敗談をはじめ、学校のこと、生活のこと、国のこと…<br />
　　直接帰国者に何でも聞いていただけるセミナーです！<br />
<br />
　　<a href="seminar">※初めての方は「初心者向けセミナー」のご参加をおススメしております。</a><br />
　　　<a href="seminar">通常セミナーのスケジュールはこちら</a><br />
<br clear="all" />

</p>


		<h2 class="sec-title-tokyosub">東京会場　体験談スケジュール</h2>

        <div style="line-height:2; font-size:14px;">
			<a href="#asami">■　オーストラリア留学体験談～オーストラリアの楽しみ方～</a><br />
            
			<a href="#yuma">■　カナダ帰国者体験談セミナー</a><br />

            <a href="#mika">■　アメリカ・カナダ体験談セミナー</a><br />

            <a href="#kotaro">■　アメリカ留学体験談 ～交換留学そして大学進学～</a><br />
        </div>

&nbsp;<br />


		<h2 class="sec-title-osakasub">大阪会場　体験談スケジュール</h2>

        <div style="line-height:2; font-size:14px;">
            <a href="#natsuki">■　オーストラリア帰国者体験談　～最高の渡航にするためのルール作り～</a><br />

            <a href="#kyoichi">■　カナダ留学体験談セミナー　～「英語嫌い」からカナダワーホリへ～</a><br />

</div>

        <br /><br />


		<h2 class="sec-title-storytokyo" style="margin-bottom:0px;">東京会場　体験談</h2>
					  	  <h2 class="sec-title-tokyosub" style="margin-bottom:10px;" id="asami">　オーストラリア留学体験談～オーストラリアの楽しみ方～<img src="http://www.jawhm.or.jp/event/getlist/img/Australia.png" align="left"></h2>
		<center>
		<img src="http://www.jawhm.or.jp/images/uploads/files/photo1.jpg" width=35%>　<img src="http://www.jawhm.or.jp/images/uploads/files/photo2.jpg"  width=35%><br /> 
		 </center>
        <br />    
        <p class="topicpath_incontent">セミナー概要</p>
    
        <p class="text01">
&nbsp;<br />  
23歳になる直前に天職だと思っていたアパレルの仕事を退職し、<br />
フィリピン留学を経てオーストラリアにワーホリへ！<br />
&nbsp;<br />  
英語を勉強して海外で生活するなんて夢にも思ってなかった私が単身オーストラリアへ！！<br />
&nbsp;<br />  
都市ごとに全然違う顔を持つオーストラリアの魅力の話や英語の生活に格闘し、<br />
なにもわからなっかた私が1年の生活でたくさんのことを経験しました。<br />
&nbsp;<br />  
自分なりに成長出来たと思う私のオーストラリアのワーホリ体験を<br />
みなさんにお話しして少しでも参考にしていただけたらと思います。<br />
&nbsp;<br />  
≪海外渡航履歴≫<br />
オーストラリア、フィリピン、韓国、ニューヨーク、タイランド、グアム<br />
&nbsp;<br />
＜セミナー担当者：山崎麻実＞<br /> 
</p>
			<p>&nbsp;</p>
        <div class="chiiki-box">
            <span class="chiiki<?php if($header_obj->computer_use()) echo' openlist'; ?>" id="asami">
                >> この体験談のスケジュール・ご予約はこちら
            </span>
            <div class="list">
				<?php
					$data = get_list('asami');
					display_list($data);
				?>
            </div>
        </div>
		
			<p>&nbsp;</p>
			<p>&nbsp;</p>
		      
			  	  <h2 class="sec-title-tokyosub" style="margin-bottom:10px;" id="yuma">　カナダ帰国者体験談セミナー<img src="http://www.jawhm.or.jp/event/getlist/img/Canada.png" align="left"></h2>
		<center>
        <img src="http://www.jawhm.or.jp/images/uploads/files/IMG_2311.jpg" width="35%">　<img src="http://www.jawhm.or.jp/images/uploads/files/IMG_2376.jpg" width="35%"><br /> 
		 </center>
        <br />    
        <p class="topicpath_incontent">セミナー概要</p>
    
        <p class="text01">
&nbsp;<br />  
バンクーバーは面白い。一言で言うとこんな感じです。<br /> 
&nbsp;<br /> 
日本に住んでいると、外国のどの都市も魅力的に感じやすいですが、バンクーバーは多種多様な魅力が詰まっています。<br /> 
語学留学としてやってきた学生は、「英語学習」以外の魅力にも、すぐに気づくと思います。<br /> 
現代的な空間のダウンタウン、少し電車で走れば何もない田舎。街を行き交う様々な人種。<br /> 
バスではとなりの人と世間話をしたり。日本人だと分かれば「日本語教えて！」とバーの店員にお願いされたり。<br /> 
タトゥーの入った怖そうな兄ちゃんが、意外にも、店のドアを開けて待ってくれたり。<br /> 
&nbsp;<br /> 
いままで自分が日本で常識だと思っていたことが壊れました、<br /> 
というかどうでも良くなるくらい、気楽で、ストレスのない、でも少しばかり忙しい都市だなと感じました。<br /> 
気候もよく、夏はカラッと晴れていて、冬もそれほど寒くないです。<br /> 
何より、公園やカフェがたくさんあって、お金を使わなくても、一日楽しめるような場所でした。<br /> 
&nbsp;<br /> 
また、留学生が集まる都市なので、同じ志を持った人にたくさん出会うことができます。<br /> 
勉強の話をしたり、少し込み入った政治の話をしたりと。<br /> 
いろいろな人種がいるところなので、様々な英語のアクセントがあります。<br /> 
なので、英語に自信がなくても、現地の人は、一生懸命理解しようと聞いてくれます。<br /> 
そういう意味でも、英語を学習したい人には、最高の場所だと思います。　<br /> 
&nbsp;<br /> 
私の場合、今でも、バンクーバーで仲良くなった友達と、連絡を取り合っています。<br /> 
「今度日本に行くから家に泊めてくれない？」「じゃあおれが行くときもよろしく！」みたいな会話が何件も（笑）<br /> 
また、勉強の相談や恋愛の話をしたりもして、日本に帰国しても、常に英語に触れることができます。<br /> 
&nbsp;<br /> 
もし、ほかの国を留学先に選んでいたら今頃どうなっているかは想像がつきませんが、<br /> 
少なくとも、バンクーバーで過ごした時間は、本当に貴重な時間でしたし、<br /> 
たくさんの大切なものを得ることができました。<br /> 
&nbsp;<br /> 
いろいろな可能性が山ほどころがっているバンクーバーで、語学はもちろんのこと、<br /> 
ほかにも、大切な多くの事を学ぶことができると、私は確信しています。<br /> 
&nbsp;<br />
＜セミナー担当者：高野　祐真＞<br /> 
</p>
			<p>&nbsp;</p>
        <div class="chiiki-box">
            <span class="chiiki<?php if($header_obj->computer_use()) echo' openlist'; ?>" id="yuma">
                >> この体験談のスケジュール・ご予約はこちら
            </span>
            <div class="list">
				<?php
					$data = get_list('yuma');
					display_list($data);
				?>
            </div>
        </div>
		
			<p>&nbsp;</p>
			<p>&nbsp;</p>
			
	  <h2 class="sec-title-tokyosub" style="margin-bottom:10px;" id="mika">　アメリカ・カナダ体験談セミナー<img src="http://www.jawhm.or.jp/images/uploads/files/Canada.gif" align="left"></h2>
		<center>
       <img src="http://www.jawhm.or.jp/images/uploads/files/photo.jpg" width=35%>　<img src="http://www.jawhm.or.jp/images/uploads/files/photo2-%281%29.jpg" width=35%>
		 </center>
        <br />    
        <p class="topicpath_incontent">セミナー概要</p>
    
        <p class="text01">
	&nbsp;<br />
	私は高校三年間を中国にあるカナディアンインターナショナルスクールで過ごし、その後、大学でアメリカオレゴン州での一年間の交換留学を経験しました。<br /> 
	&nbsp;<br />
	アメリカでの交換留学では、現地の学生となるべく多く交流するように心がけ、友達と動物園に行ったり、ショッピングに行ったり、日本料理を作ったり、日本語を教える代わりに英語を教えてもらいながら一緒に勉強したりと本当にいろいろなことをしました。<br /> 
	&nbsp;<br />
	また、ホームステイも経験し、アメリカ人のライフスタイルを知るだけでなく、クリスマスやサンクスギビングなどの伝統的なイベントを体験し、アメリカ文化に対する理解も深められました。<br /> 
	&nbsp;<br />
	渡航前は人見知りがちで英語を話すことにも自信がありませんでした。
しかし一年間の交換留学を通して、アメリカ人の明るくポジティブな性格に刺激され、人と話すことが楽しくなりました。そして現地で学校に通って生きた英語を学ぶことで、自分の英語力にも自信を持てました。<br /> 
	&nbsp;<br />
	この経験を生かして、セミナーでは私の現地での体験談以外にも、渡航前の英語の勉強法、現地での住まい、ホームステイについて、現地の人との交流、海外生活においての注意点などについてお話させていただきます。<br /> 
	&nbsp;<br />
	また渡航中にアメリカ・カナダの主要都市を旅行しましたので、アメリカ・カナダで都市を迷われている方へのアドバイスもさせていただきます。<br />
	&nbsp;<br />
	＜セミナー担当者：石川　みか＞<br /> 
		</p>
			<p>&nbsp;</p>
        <div class="chiiki-box">
            <span class="chiiki<?php if($header_obj->computer_use()) echo' openlist'; ?>" id="mika">
                >> この体験談のスケジュール・ご予約はこちら
            </span>
            <div class="list">
				<?php
					$data = get_list('mika');
					display_list($data);
				?>
            </div>
        </div>
		
			<p>&nbsp;</p>
			<p>&nbsp;</p>
			
        	<h2 class="sec-title-tokyosub" style="margin-bottom:10px;" id="kotaro">　アメリカ留学体験談 ～交換留学そして大学進学～<img src="http://www.jawhm.or.jp/images/uploads/files/USA.png" align="left"></h2>

        
        <br />    
        <p class="topicpath_incontent">セミナー概要</p>
    
        <p class="text01">
	私は高校生の時、交換留学生として1年間アメリカに留学し、その後アメリカ・ニューヨーク州の大学に進学しました。最終的にアメリカの大学に5年間在学し、単位をもってアメリカの大学を卒業しました。<br />
	&nbsp;<br />
	留学当初は全く英語を話すことができず、また内気な性格だったため単純なコミュニケーションをとることもできず、大変苦労しました。しかし明るくフレンドリーなアメリカ人に接することができたことで、単純な語学力だけでなく自分自身の性格まで変えることができました。大学では獣医学科を専攻し、元々全く英語ができなかった自分がアメリカで医療系の単位を取ることができたのも、アメリカでの生活で自分に自信を持てるようになったからだと思います。<br />
	&nbsp;<br />
	私にはアメリカ滞在中学生寮・ホームステイ・ルームシェアをそれぞれ経験し、長期にわたりアメリカに滞在していた経験があります。セミナーでは私の現地での体験談以外にも、英語の勉強法、授業風景、現地での住まい、ホームステイについて、友達の作り方、注意することなどについてお話させていただきます。<br />
	&nbsp;<br />
	＜セミナー担当者：真田　浩太郎＞<br /> 
		</p>
			<p>&nbsp;</p>
        <div class="chiiki-box">
            <span class="chiiki<?php if($header_obj->computer_use()) echo' openlist'; ?>" id="kotaro">
                >> この体験談のスケジュール・ご予約はこちら
            </span>
            <div class="list">
				<?php
					$data = get_list('kotaro');
					display_list($data);
				?>
            </div>
        </div>

		<div style="margin-bottom:10px;">&nbsp;</div>

        <hr class="separate-line" />
        <br /><br />
			
		<h2 class="sec-title-storyosaka" style="margin-bottom:0px;">大阪会場　体験談</h2>
		
		      
			  	  <h2 class="sec-title-osakasub" style="margin-bottom:10px;" id="natsuki">　「オーストラリア帰国者体験談」～最高の渡航にするためのルール作り～<img src="http://www.jawhm.or.jp/event/getlist/img/Australia.png" align="left"></h2>
        <p class="topicpath_incontent">セミナー概要</p>
    
        <p class="text01">
&nbsp;<br />  
大学生の頃、オーストラリアに念願であった1年間留学をしました。<br />  
渡航内容としては、語学学校に半年間、交換留学生として大学に半年間通いました。<br />  
&nbsp;<br />  
友達をたくさんつくりたい！！英語がぺらぺらになって帰国したい！！<br />  
と意気込んで渡航した私に立ちふさがったのは、やはり言葉の壁でした。<br />  
&nbsp;<br />  
そこで自分の中で２つのルールを決めました。<br />  
そのルールを実行していく内に、段々と英語にも慣れ、自信が出てきました。<br />  
小さなルールでいいです。自分なりのルールを渡航前から決めて行くと、<br />  
なお有意義に時間を過ごせるのではないかと考えます。<br />  
&nbsp;<br />  
またセミナーでは、留学を決意したきっかけ、海外での1日の生活スタイル、<br />  
実践していた楽しく英語力を伸ばす方法、語学学校に通いながら現地人の友達の作りかた、<br />  
色んなホストファミリーの例、ハウスメイトとの出会い、海外で気づく日本人の特徴など<br />  
私の体験談を踏まえつつお話させていけたらと思います。<br />  
&nbsp;<br />  
海外渡航という貴重な機会を自分次第で良くも悪くもすることができます。<br />  
みなさまの海外生活をより良いものにするために、何か参考にしていただければ幸いです。<br />  
&nbsp;<br />
＜セミナー担当者：石田　夏季＞<br /> 
</p>
			<p>&nbsp;</p>
        <div class="chiiki-box">
            <span class="chiiki<?php if($header_obj->computer_use()) echo' openlist'; ?>" id="natsuki">
                >> この体験談のスケジュール・ご予約はこちら
            </span>
            <div class="list">
				<?php
					$data = get_list('natsuki');
					display_list($data);
				?>
            </div>
        </div>
		
			<p>&nbsp;</p>
			<p>&nbsp;</p>			
			
	  <h2 class="sec-title-osakasub" style="margin-bottom:10px;" id="kyoichi">　カナダ留学体験談セミナー　～「英語嫌い」からカナダワーホリへ～<img src="http://www.jawhm.or.jp/event/getlist/img/Canada.png" align="left"></h2>
		<center>
       <img src="http://www.jawhm.or.jp/images/uploads/files/KYO02.jpg" width=40%>
		 </center>
        <br />       
        <p class="topicpath_incontent">セミナー概要</p>
    
        <p class="text01">
			&nbsp;<br /> 
			TOEIC210点…知っている単語は挨拶程度。<br />
			そんな私がネイティブカナダディアンと過ごした海外バンクーバー生活。<br /> 
&nbsp;<br /> 
			カナダ・バンクーバー。<br />
			世界一住みやすい都市と言われているこの地で、私はワーキングホリデービザにて９ヶ月滞在していました。<br /> 
			『英語嫌い』な学生時代は、英語の授業を真面目に受けた記憶はありません。<br />
			渡航前に試しに受けたTOEICは210点。<br />
			そんな私が、海外バンクーバーで帰国時には、ネイティブカナディアンやアメリカ人の友達が出来ていました。<br /> 
&nbsp;<br /> 
			留学は十人十色で、何が『成功』なのかはわかりません。<br /> 
			しかし、限られた海外生活を有意義な期間にするために<br />
			私がバンクーバーで実際に実行してきた事をご紹介させて頂きます。<br /> 
&nbsp;<br /> 
			■なぜバンクーバー？<br /> 
			■渡航前の準備等<br /> 
			■留学当初の生活<br /> 
			■自分なりの英語勉強方法<br /> 
			■海外でのボランティア活動<br /> 
&nbsp;<br /> 
			など以上の事以外もセミナーにてお話しさせて頂きます。<br /> 
	</p>
			<p>&nbsp;</p>
        <div class="chiiki-box">
            <span class="chiiki<?php if($header_obj->computer_use()) echo' openlist'; ?>" id="kyoichi">
                >> この体験談のスケジュール・ご予約はこちら
            </span>
            <div class="list">
				<?php
					$data = get_list('kyoichi');
					display_list($data);
				?>
            </div>
        </div>
		
				<div style="margin-bottom:10px;">&nbsp;</div>

        <hr class="separate-line" />
        <br /><br />
			
<!--
		<h2 class="sec-title-story2" style="margin-bottom:0px;">名古屋会場　体験談</h2>
		
		      
			  	  <h2 class="sec-title-skyblue" style="margin-bottom:10px;">　「オーストラリア帰国者体験談」～最高の渡航にするためのルール作り～<img src="http://www.jawhm.or.jp/event/getlist/img/Australia.png" align="left"></h2>
        <p class="topicpath_incontent">セミナー概要</p>
    
        <p class="text01">
&nbsp;<br />  
大学生の頃、オーストラリアに念願であった1年間留学をしました。<br />  
渡航内容としては、語学学校に半年間、交換留学生として大学に半年間通いました。<br />  
&nbsp;<br />  
友達をたくさんつくりたい！！英語がぺらぺらになって帰国したい！！<br />  
と意気込んで渡航した私に立ちふさがったのは、やはり言葉の壁でした。<br />  
&nbsp;<br />  
そこで自分の中で２つのルールを決めました。<br />  
そのルールを実行していく内に、段々と英語にも慣れ、自信が出てきました。<br />  
小さなルールでいいです。自分なりのルールを渡航前から決めて行くと、<br />  
なお有意義に時間を過ごせるのではないかと考えます。<br />  
&nbsp;<br />  
またセミナーでは、留学を決意したきっかけ、海外での1日の生活スタイル、<br />  
実践していた楽しく英語力を伸ばす方法、語学学校に通いながら現地人の友達の作りかた、<br />  
色んなホストファミリーの例、ハウスメイトとの出会い、海外で気づく日本人の特徴など<br />  
私の体験談を踏まえつつお話させていけたらと思います。<br />  
&nbsp;<br />  
海外渡航という貴重な機会を自分次第で良くも悪くもすることができます。<br />  
みなさまの海外生活をより良いものにするために、何か参考にしていただければ幸いです。<br />  
&nbsp;<br />
＜セミナー担当者：石田　夏季＞<br /> 
</p>
			<p>&nbsp;</p>
        <div class="chiiki-box">
            <span class="chiiki<?php if($header_obj->computer_use()) echo' openlist'; ?>" id="pgkouen">
                >> この体験談のスケジュール・ご予約はこちら
            </span>
            <div class="list">
				<?php
					$data = get_list('pgkouen');
					display_list($data);
				?>
            </div>
        </div>
		
			<p>&nbsp;</p>
			<p>&nbsp;</p>			
			
	  <h2 class="sec-title-skyblue" style="margin-bottom:10px;">　カナダ留学体験談セミナー<img src="http://www.jawhm.or.jp/event/getlist/img/Canada.png" align="left"></h2>

        
        <br />    
        <p class="topicpath_incontent">セミナー概要</p>
    
        <p class="text01">
		“学生生活の岐路”大学を休学して、カナダ・バンクーバーへ。<br />  
&nbsp;<br /> 
		私は、大学を一年休学してカナダ・バンクーバーへ<br />  
		2012年3月から9ヶ月間語学留学しておりました。<br />  
&nbsp;<br /> 
		現地での辛かった事・自分なりの英語勉強方法・帰国後の心境を、<br />  
		現在海外留学をお考えのみなさまに、わかりやすくお話させて頂きます。<br />  
	</p>
			<p>&nbsp;</p>
        <div class="chiiki-box">
            <span class="chiiki<?php if($header_obj->computer_use()) echo' openlist'; ?>" id="pgkouen">
                >> この体験談のスケジュール・ご予約はこちら
            </span>
            <div class="list">
				<?php
					$data = get_list('pgkouen');
					display_list($data);
				?>
            </div>
        </div>
		
		<div style="margin-bottom:10px;">&nbsp;</div>

        <hr class="separate-line" />
		-->
		
        <br /><br />

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
            <img src="../images/flag01.gif" alt="" />
            <img src="../images/flag03.gif" alt="" />
            <img src="../images/flag09.gif" alt="" />
            <img src="../images/flag05.gif" alt="" />
            <img src="../images/flag06.gif" alt="" />
            <img src="../images/mflag11.gif" alt="" width="40" height="26" />
            <img src="../images/flag08.gif" alt="" />
            <img src="../images/flag04.gif" alt="" />
            <img src="../images/flag02.gif" alt="" />
            <img src="../images/flag10.gif" alt="" />
            <img src="../images/flag07.gif" alt="" />
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
                <img src="../images/ajaxwait.gif" alt="" />
                &nbsp;予約処理中です。しばらくお待ちください。&nbsp;
                <img src="../images/ajaxwait.gif" alt="" />
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