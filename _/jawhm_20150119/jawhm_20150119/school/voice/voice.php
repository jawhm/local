	  <h2 class="sec-title">留学・ワーホリ経験者からの声</h2>

<?php
$sponsors = array(
	array('ih','カナダは寒いというイメージしかなかったのですが、夏のバンクーバーは雨が少なくカラッとしていてとても過ごしやすいところです。それでも、こちらの生活に慣れるのは少し大変でした。なぜなら....'),
	array('ilac','留学する3ヶ月ほど前、海外のお客様から電話がかかってきたときパニックになり「すみません、外国の方からハローと言われました。」と言葉にした私...'),
	array('ilsc','大学４年生で就職活動をはじめるときに、ずっと憧れていた海外留学をこのまましないで卒業してもいいのか？という迷いと、社会に出る自分に対しても自信が持てない私...'),
	array('kgic','海外の企業でのインターンシップとTESOL (Teaching English to Speakers of other Languages)の資格の取得。それが私の目標！！'),
	array('nzlc','ニュージーランドに来てしっかりと英語を自分のものにし、充実した生活を送るのに最適な場所がここにあります。'),
	array('selc','動物病院でナースとグルーマーとして長い間仕事を続けていて、頭で考えなくとも体が動く。こなしていた仕事。好きなのか、好きじゃないのか。なぜ続けているのか。そんな私が、何かを探しにオーストラリアへ'),
	array('umc','スクールメイトとは週末も出かけたり、時には旅行に行ったり、とにかくアクティブにフットワーク軽く行動しています。時間が限られているので行動あるのみ！'),
	array('viva','英会話を習い始めてから海外の生活に興味を持ち、海外で生活をしてみたい。それが1 番の理由でした。日常とは異なる環境で何か自分で挑戦し、生活してみたいと思いました。'),
	array('ccel','学生時代、苦手だった英語を克服したくて留学を決めた私。カナダ・バンクーバーで沢山の友達ができました。'),
	array('browns','無料のアクティビティが毎日あって大変充実してい ること。それが私が選んだ理由。'),
	array('ihsyd','将来の夢はやっぱり「先生になること」 Everything is possible, nothing is impossible!!! Better to regret the things you do, than the things you don’t do!!!'),
	array('quest','初めの2カ月は仕事をするために必要な英語を学ぶため、ビジネス英語コースに所属しました。ビジネスの場が想定されたミーティングや商談等、実践的な内容が多く含まれ、非常に充実した授業でした。'),
	array('inforum','ジェスチャーとかで通じることもあるけど、それでは心を開いて話せない。みんなが楽しそうに話してるのをただ作り笑いして聞いているのはもったいない！本当に最初はそんなことから英語を勉強したいと思うようになりました。'),
	array('navitas','オーストラリアは留学、旅行どちらにもとても適した素晴しい環境の国です。'),
	array('icqa','私がInternship Programに参加をしようと思ったきっかけは、“なにか新しいことに挑戦したい”というシンプルなものでした。'),

);
shuffle($sponsors);
?>

	<div class="sponsorListHolder">
        <?php
		foreach($sponsors as $company)
		{
			echo'
			<div class="sponsor" title="'.$company[0].'">
				<div class="sponsorFlip">
					<img src="/school/voice/'.$company[0].'/flip.png" alt="More about '.$company[0].'" />
				</div>
				
				<div class="sponsorData">
					<div class="sponsorDescription">
						'.$company[1].'
					</div>
					<div class="sponsorURL">
						　　　<a href="/school/voice/'.$company[0].'/">>>>　続きはこちら　>>></a>
					</div>
				</div>
			</div>
			
			';
		}
	?>
    	<div class="clear"></div>
	</div>
