    
    <div data-role="page" id="step5" class="jquery">
    
        <div id="header-box">
            <h1>メンバー登録</h1>
        </div><!-- /header -->
        
        <div data-role="content" data-theme="b">
         	<h2>STEP 5</h2>
            <?php
				// if mail already exist
				if($_GET['from']=='mailexist')
				{	?>
                    <h3>入力されたメールアドレスは既に使用されています。</h3>
            <?php
				}
				else 
				{ ?>
                    <h3>メンバー登録ありがとうございました。</h3>
            <?php
				} ?>
            <?php
				switch(secure($_GET['from']))
				{
					case 'furikomi':
							echo	'ご登録頂きましたメールアドレスに、振込先口座情報をお送りしました。<br/>'
									.'なお、お手数ですが、振込後に当協会までご連絡頂けますようお願い申し上げます。<br/>';	
						break;
					case 'card':
							echo	'クレジットカードでのお支払いが確認できました。<br/>'
									.'ご登録頂いた住所に会員証をお送りいたします。<br/>';	
						break;
					case 'conv':
							echo	'メンバー登録料をご指定のコンビニでお支払ください。<br/>'
									.'登録料のお支払が確認できた後、ご登録頂きました住所に会員証をお送り致します。<br/>';	
						break;
					case 'mailexist':
							echo	'ログインする場合は、<a href="https://www.jawhm.or.jp/member/" type="button" data-transition="pop" data-theme="b" data-inline="true" >こちらから</a>　どうぞ。<br />'
									.'登録した覚えがない場合は、info@jawhm.or.jp までお問い合わせください。<br/>';	
						break;
				}
			?>
            <?php
				// if mail already exist
				if($_GET['from']=='mailexist')
				{	?>
                	<p><a href="https://www.jawhm.or.jp/mobileform/member_form.php" type="button" data-transition="pop" data-theme="b"  >メンバー登録を最初からやり直す場合は、こちらからどうぞ</a></p>
            <?php
				}
				else 
				{ ?>
                    <p><a href="http://www.jawhm.or.jp/" data-rel="dialog" type="button" data-transition="pop" data-theme="b" data-icon="home" >それでは、ワーホリの準備を始めましょう！！</a></p>
            <?php
				} ?>

             
        </div><!-- /content -->
        
       <?php echo footer(); ?>
         
    </div>