<?php


include './seminar_module/seminar_module.php';
$config = array(
	'view_mode' => 'list',
	'seminar_id' => '2014',
	'list' => array(
		'past_view' => 'on',
		'count_field_active' => '',
		'place_default' => '',
	)
);
$sm = new SeminarModule($config);


require_once 'include/header.php';
//require_once 'seminar/include/kouen_function.php';

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
' . $sm->get_add_style();
$header_obj->add_css_files = $sm->get_add_css();
$header_obj->add_js_files = $sm->get_add_js();

$header_obj->fncMenuHead_imghtml = '<img id="top-mainimg" src="images/mainimg/top-mainimg.jpg" alt="" alt="" width="970" height="170" />';
$header_obj->fncMenuHead_h1text = '日本ワーキングホリデー協会の講演セミナー情報';

$header_obj->display_header();

?>
	<div id="maincontent">
		<?php echo $header_obj->breadcrumbs(); ?>
		<br />

		<h2 class="sec-title" style="margin-bottom:30px;">講演セミナーとは？</h2>
<p class="text01">
<img src="images/kouen/image.jpg" alt="" style="float:left;"/>
　　渡航前の気になる各テーマに沿って、<br />
　　通常のセミナーとは一味違った「講演会セミナー」を行っております。<br />
　　様々な分野のプロフェッショナルを各国からお呼びする特別セミナーとなっております。<br />
　　「英語の上達方法」、「実際に留学した方の体験談」、「帰国後の就職」…など<br />
　　これからワーホリ＆留学を考える方必見の内容です。<br />
<br />
　　<a href="seminar">※初めての方は「初心者向けセミナー」のご参加をおススメしております。</a><br />
　　　<a href="seminar">通常セミナーのスケジュールはこちら</a><br />
<br />
</p>

        <div style="line-height:2.5; font-size:14px;">





        </div>


		<h2 class="sec-title">講演セミナー一覧</h2>

        <div style="line-height:2; font-size:14px;">
            <a href="#pg">■　体験談から学ぶ！！就職力・転職力UP留学セミナー -企業が求める人材とは-</a><br />

            <a href="#kgic">■　留学前に日本で出来る英語の上達法</a><br />

            <a href="#gl">■　出発前の方向け：「企業が求める海外経験・グローバル人材とは」<br />
            ■　帰国者向け：「海外経験を活かした就職活動の仕方について」</a><br />
<br />

        </div>

		<h2 class="sec-title" style="margin-bottom:30px;">講演セミナー詳細</h2>
        
    
        <span class="bluelist" id="pg">体験談</span>
        <span class="bluelist">帰国後の就職・転職</span>
        <span class="bluelist">英語の伸ばし方</span>
        <span class="bluelist">カナダ語学学校</span>
        <br /><br />
    
        <span class="main-line"><strong>体験談から学ぶ！就職力・転職力UP留学セミナー</strong> -企業が求める人材とは-</span>
    
        <br /><br />
        <p class="topicpath_incontent">講師紹介</p>
        
        <p class="text01">
            <img src="images/kouen/pgic.jpg" alt="" style="float:left;"/>
            <font size="2" color="#333333"><strong>PGIC(カナダ語学学校)　佐々木　健志 様</strong></font><br />
            <small>
                20歳で大学を休学し、英語力ゼロでカナダ、バンクーバーに留学。<br />
                1年で上級レベルに進級し、TOEICではリスニングで満点を取得。<br />
                海外でのルームシェアや得意分野を活かした野球コーチなど、さまざまな経験を経て海外語学学校のスタッフに。<br />
                現在は、語学学校のマーケティングスタッフをしながら日本、カナダ、オーストラリアの3カ国での留学・就労経験などをもとに
                学生、社会人を対象にしたセミナーを行っている。
            </small>
        </p>
        <br />
    
        <p class="topicpath_incontent">セミナー概要</p>
    
        <p class="text01">
            カナダ留学した帰国者の体験談が聞けるセミナーです。<br />
            留学前は英語が全くわからずTOEIC点数も300点以下からのスタートでしたが<br />
            1年間英語漬けで努力しTOEIC900点以上リスニングほぼ満点まで語学力を伸ばし<br />
            外資系企業に就職が決まりました。<br />
            ご自身の体験を含めながら英語上達のコツを聞く事が出来ます。<br />
            使える英語を身に付けたい方は特にご参加下さい。<br />
            <br />
            -企業が求める人材とは-<br />
            <br />
            不況の今こそ、自分磨きの絶好のチャンス。<br />
            留学後の就職・転職活動は留学前からすでに始まっています。<br />
            積極性やコミュニケーションスキル、問題解決能力など、企業が社員に求める能力には、<br />
            「留学・ワーキングホリデー」を通して得られるものが多くあります。<br />
            <br />
            このセミナーでは、留学経験を就職や転職に活かした先輩達の実例をもとに、
            効果的な留学をするためのポイントを伝授します。<br />
            さらに、体験者の留学パターンと帰国後の仕事についてもお伝えします。<br />
            <br />
        </p>
    
        <div class="chiiki-box">
			<?php $count = $sm->show(); ?>
			<!--
            <span class="chiiki<?php if($header_obj->computer_use()) echo' openlist'; ?>" id="pgkouen">
                >> この講演会のスケジュール・ご予約はこちら
            </span>
            <div class="list">
				<?php
					//$data = get_list('pgkouen');
					//display_list($data);
				?>
            </div>
             -->
        </div>

        <hr class="separate-line" />
    
        <span class="bluelist" id="kgic">英語の伸ばし方</span>
        <span class="bluelist">カナダ語学学校</span>
        <br /><br />
    
        <span class="main-line"><strong>留学前に日本で出来る英語の上達法</strong></span>
    
        <br /><br />
        <p class="topicpath_incontent">講師紹介</p>
        
        <p class="text01">
            <img src="images/kouen/kgic.gif" alt="" style="float:left;margin-bottom:20px;">

            <div style="margin-top:50px;"><font size="2" color="#333333"><strong>KGIC（カナダ語学学校）　本庄　伊吹 様</strong></font></div>
        </p>
        <br />
    
        <p class="topicpath_incontent">セミナー概要</p>
    
        <p class="text01">
	英語でどう上手にコミュニケーションをとれるのか<br />
	思想トレーニングの大切さ<br />
	語彙力増加の方法、会話はどう上達していくか<br />
<br />
	ご出発前に抑えておきたいポイントをお話ししていただきます。<br />
	英語力が不安な方、出発前に日本でできるだけ英語力を伸ばしておきたい方におススメです。<br />
<br />
        </p>
    
        <div class="chiiki-box">
            <span class="chiiki<?php if($header_obj->computer_use()) echo' openlist'; ?>" id="kgickouen">
                >> この講演会のスケジュール・ご予約はこちら
            </span>
            <div class="list">
				<?php
					//$data = get_list('kgickouen');
					//display_list($data);
				?>
            </div>
        </div>

    
        <hr class="separate-line" />
    
        <span class="bluelist" id="gl">帰国後の就職活動</span>
        <span class="bluelist">グローバル人材</span>
        <br /><br />
    
        <span class="main-line"><font size="2">出発前の方向け：</font><strong>「企業が求める海外経験・グローバル人材とは」</strong></span><br />
        <span class="main-line"><font size="2">帰国者の方向け：</font><strong>「海外経験を活かした就職活動の仕方について」</strong></span>
        
        <br /><br />
        <p class="topicpath_incontent">講師紹介</p>
    
    
        
        <p class="text01">
            <img src="images/kouen/gl.jpg" alt="" style="float:left;margin-bottom:20px;"/>
            <div style="margin-top:50px;"><font size="2" color="#333333"><strong>株式会社代表取締役　神田　滋宣 様</strong></font></div>
        </p>
    
        <p class="topicpath_incontent">セミナー概要</p>
        <p class="text01">
            <b>■出発前の方向け：「企業が求める海外経験・グローバル人材とは」■</b><br />
            <br />
            皆様がご存知の通り、日本の総人口は急激に減少しています。<br />
            2035年には人口の10％が減少し、2050年には人口が1億人を下回ります。<br />
            これは日本国内のビジネスにおけるニーズが極めて早いペースで縮小していることを意味します。<br />
            <br />
            私たち日本の経済成長が低迷している一方で、中国、インドをはじめとする<br />
            東南アジアの途上国マーケットの成長率は、どの国を見ても平均5％以上の成長となっており、<br />
            将来有望なマーケットとして捉えられています。<br />
            <br />
            このような背景から、日本企業が海外進出をしないという選択肢はもはやないに等しいのです。<br />
            つまり、今後の急速に高まる企業の海外展開を担うグローバル人材のニーズが非常に高まっていると言えます。<br />
            <br />
            「それでは実際に企業が求める海外経験とはどのようなものなのか？」<br />
            「就職に活きる海外経験を得るためには、具体的にどのように行動したらいいのか？」<br />
            これまで数多くのグローバル展開をする企業の採用現場を見てきた<br />
            GLナビゲーション株式会社代表取締役の神田が詳しくお話致します！<br />
            <br /><br />
            <b>■帰国者向け：「海外経験を活かした就職活動の仕方について」■</b><br />
            <br />
            海外で貴重な経験を得てきた皆様、海外経験を活かす仕事と考えるとどのような職種を思い浮かべるでしょうか。<br />
            総合商社、メーカー、貿易事務、このように直接的に海外と繋がりがあるお仕事を思い浮かべる方も多いのではないでしょうか。<br />
            <br />
            しかし上記の仕事は集まる人数に対しての枠が非常に少なく、狭き門であることが事実です。<br />
            例えば貿易事務は1人の枠に対して200人の応募が来ます。<br />
            海外経験を本当に活かせる仕事、それは日系企業の海外展開を担う仕事なんです。<br />
            <br />
            セミナーでは海外経験を活かした就職活動について、「自己分析の方法」や<br />
            「企業分析の方法」など就職活動の基本はもちろんのこと、<br />
            実際にどのようなアクションを起こして就職活動を進めるのかを詳しくお話致します。<br />
        </p>
		<br />
        <div class="chiiki-box">
            <span class="chiiki<?php if($header_obj->computer_use()) echo' openlist'; ?>" id="glkouen">
                >> この講演会のスケジュール・ご予約はこちら
            </span>
            <div class="list">
				<?php
					//$data = get_list('glkouen');
					//display_list($data);
				?>
            </div>
        </div>

 <!--       <hr class="separate-line" />

        <span class="bluelist" id="careerplan">海外就職</span>
        <span class="bluelist">シンガポール就職</span>
        <span class="bluelist">体験談</span>
        <br /><br  />

        <span class="main-line"><strong>海外就職成功の秘訣セミナー</strong></span>
        
        <br /><br />
        
        <p class="topicpath_incontent">講師紹介</p>
        <br />

		<p class="text01">
    		<img src="images/careerplan.jpg" alt="" style="float:left;margin-bottom:20px;"/>
			<font size="2" color="#333333"><b>キャリアプラン オーストラリア社　代表取締役社長　加藤　友章</b>（カトウ　トモアキ）</font><br />
			<small>
                大手メーカーの海外駐在員として１５年間オーストラリア、ニュージーランド、
                シンガポール、タイ、ベトナムに駐在。<br />
                その後２０００年にメーカーを退職しシンガポールで通信系ＩＴ企業設立。<br/>
                ２００５年にシドニーで語学学校ワラビーインターナショナルカレッジ設立。<br/>
                英語力を活かし海外で活躍したい人材への的確なアドバイスが必要と考え、<br/>
                ２００８年キャリアプラン　オーストラリア社を設立。<br/>
                東南アジア地域（主にはシンガポール）での正式な就労ビザを取得しての
                正社員勤務紹介のみを扱い現在に至る。
            </small>	
		</p>
        <br />

        <p class="topicpath_incontent">セミナー概要</p>

        <p class="text01">
            <b>１）海外就職には何が必要か？<br />
            ２）海外就職で求められる人材は？<br />
            ３）シンガポール就職の優位点は？<br /></b>
            <br />
            などについての実例を含めた内容で、実際にシンガポール就職のご案内をされている会社の<br />
            スタッフの方をお呼びしてお話して頂く、充実したセミナーとなっております。<br />
            <br />
        </p>

        <div class="chiiki-box">
            <span class="chiiki<?php if($header_obj->computer_use()) echo' openlist'; ?>" id="careerplan">
                >> この講演会のスケジュール・ご予約はこちら
            </span>
            <div class="list">
				<?php
					//$data = get_list('careerplan');
					//display_list($data);
				?>
            </div>
        </div>
-->
<!--        <span class="bluelist" id="nagoya">海外就職</span>
        <span class="bluelist">帰国後の就職・転職</span>
        <span class="bluelist">現地での生活状況</span>
        <span class="bluelist">体験談</span>
        <span class="bluelist">英語の伸ばし方</span>

        <br /><br />
            
		<span class="main-line"><strong>新聞記者が目にした海外在住者、「海外の日本人とは」</strong></span>

		<br /><br />
		<p class="topicpath_incontent">講師紹介</p>
        
        <p class="text01">
        	<img src="images/nagoyakoen.jpg" alt="" title="" style="float:left; margin-bottom:30px;" />
            <font size="2" color="#333333"><strong>オルタナティブコミュニケーションズ<br />ディレクター 安藤久史（アンドウ ヒサシ）様</strong></font><br />
            <small>愛知県岡崎市出身。長崎県立大学経済学部卒。<br />
                在学中、メキシコ・グアダラハラ自治大学 （ＵＡＧ）に留学（スペイン語）。<br />
                ソウル大学国際大学院・国際協力学専攻修了。<br />
                共同通信グループで経済担当の記者としてシンガポールなどに駐在。<br />
                海外在住歴は留学を含め計13年。 海外生活を通じて、地域社会の重要性を再認識し、地元への帰省を決意。<br />
                2012年、同グループを退社し、広告・広報戦略を手掛けるオルタナティブコミュニケーションズに転職。<br />
            </small>
        </p>
        <br />

        <p class="topicpath_incontent">セミナー概要</p>

        <p class="text01">
			セミナー内容は、自分自身の留学経験から駐在員として接してきた日本人社会、海外の就職事情が中心となります。<br />
			記者時代には、韓国や中国、タイ、フィリピン、シンガポール、オーストラリア、インドを担当。<br />
			現地で活躍する日系企業を取材する中で、日本人駐在員が現地社員との間で抱える文化の違い、<br />
			コミュニケーション能力の必要性を目の当たりにしました。<br />
            <br />
			特にコミュニケーション能力では、各国で求められている内容の違いに驚きました。<br />
			日本では常識なマナーが、海外では非常識となる。海外で活躍する日本人像とは。<br />
			英語を流暢に話す日本人でも、就職希望先を日系企業か現地（外資）企業にするかで、求められる要素が大きく異なります。<br />
            <br />
			オーストラリアでは、世界でも名前が知られている一流大学を卒業した若者が、<br />
			故郷の田舎町で農業に従事する事例は珍しくありません。<br />
			農業を取り巻く環境も世界各国、さまざまです。<br />
            <br />
			セミナーでは、「日本で思い描いた海外生活」「海外で感じた日本」についても触れ、留学前の参考にしていただきたいと思います。<br />
            <br />
		</p>
        
        <div class="chiiki-box">
        	<span class="chiiki<?php if($header_obj->computer_use()) echo' openlist'; ?>" id="nagoya">
       			>> この講演会のスケジュール・ご予約はこちら
        	</span>
            <div class="list">
				<?php
					//$data = get_list('nagoya');
					//display_list($data);
				?>
            </div>
        </div>

		<hr class="separate-line" />-->

       <!-- <span class="bluelist" id="umc">英語レッスン</span>
        <span class="bluelist">語学学校体験</span>
        <span class="bluelist">英語の伸ばし方</span>
        <span class="bluelist">カナダ語学学校</span>
        <br /><br />

		<span class="main-line"><strong>カナダでスグに使える英語”の体験レッスン</strong></span>
        
        <br /><br />
        <p class="topicpath_incontent">講師紹介</p>
		<br />

        <img src="images/umc.jpg" alt="" style="float:left; margin-bottom:20px;" /><font size="2" color="#333333">カナダ語学学校<br /><strong>UMC(Upper Madison College) 財田　歩弥 様</strong></font>
    
        <p class="topicpath_incontent">セミナー概要</p>
    
        <p class="text01">
            中・高英語教員資格を持つカナダ語学学校日本人スタッフによる“カナダでスグに使える英語”の体験レッスン<br />
            <br />
            カナダトロントの語学学校で勤務している中・高英語教員資格を持つ日本人スタッフを招いて、<br />
            日本の英語教育とカナダの語学学校での英語教育の違いを模擬レッスンを通して体験できるイベントです。<br />
            <br />
            日本にいる間に具体的なESLのカリキュラム内容を知ることで、<br />
            海外の語学学校に入ってからのビジョンを正確に描けることはもちろん、<br />
            日本にいる間にどのような英語学習をしておけば良いかを知るきっかけとなること間違いナシ！<br />
            留学前のモチベーションUPに繋がるセミナーです。<br />
            <br />
        </p>
        
        <div class="chiiki-box">
            <span class="chiiki<?php if($header_obj->computer_use()) echo' openlist'; ?>" id="umckouen">
                >> この講演会のスケジュール・ご予約はこちら
            </span>
            <div class="list">
				<?php
					//$data = get_list('umckouen');
					//display_list($data);
				?>
            </div>
        </div>
    
        <hr class="separate-line" />-->


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
		<!--
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
        -->
	</div><!--main content-->
<!--	</div>-->  
  </div>
  </div>
	<?php fncMenuFooter($header_obj->footer_type); ?>
</body>
</html>