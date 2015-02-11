<?php
	
	//check if we get from email
	if(!isset($_GET['store']) && !isset($_GET['payment']))
	{
		$email = secure(@$_GET['email']);
		$id = secure(@$_GET['id']);
		
		// get mail from database
		try 
		{
			//connect to database
			$db = connexion_database ();

			$stt = $db->prepare('SELECT email FROM memlist WHERE id="'.$id.'"');
			$stt->execute();
			while($row = $stt->fetch(PDO::FETCH_ASSOC)){
				$cur_email = $row['email'];
			}
			$db = NULL;
		} 
		catch (PDOException $e) 
		{
			die($e->getMessage());
		}
		
		//compare two mails
//		if($email != md5($cur_email))
		if($email != $cur_email)
		{
			//redirect to the beginning of the registration form
			header("location:member_form.php");
		}
		else
			$from_url = 'ok';

	}
	
	//Getting information from data base
	try 
	{
		
		if($from_url == 'ok')
			$dat_id = $id;
		else
			$dat_id = secure($_GET['id']);
		
		//connect to database
		$db = connexion_database ();
		
		$stt = $db->prepare('SELECT namae, email, add1, add2, tel, state FROM memlist WHERE id = "'.$dat_id.'" ');
		$stt->execute();
		
		while($row = $stt->fetch(PDO::FETCH_ASSOC))
		{
			$cur_namae = $row['namae'];
			
			$dat_email = $row['email'];
			$dat_adr1 = $row['add1'];
			$dat_adr2 = $row['add2'];
			$dat_tel = $row['tel'];
			$dat_state = $row['state'];
		}
		$db = NULL;
	}
	catch (PDOException $e) 
	{
		die($e->getMessage());
	}
	
	$split_name	= mb_split("　", $cur_namae);
	$dat_name1	= $split_name[0];
	$dat_name2	= $split_name[1];

	$dat_name1	= $cur_namae;
	$dat_name2	= '　';
	
	
	//  * Create Sid number *
	// Retrieve original number for Sid
	try {
		//connect to database
		$db = connexion_database ();
		
		$stt = $db->prepare('SELECT seq FROM kessai_seq');
		$stt->execute();
		$cur_seq = '0';
		while($row = $stt->fetch(PDO::FETCH_ASSOC)){
			$cur_seq = $row['seq'];
		}
		$db = NULL;
	} catch (PDOException $e) {
		die($e->getMessage());
	}
	// Increase the number by 1
	$cur_num = intval($cur_seq) + 1;
	
	// Update the number
	try {
		//connect to database
		$db = connexion_database ();
		
		$stt = $db->prepare('UPDATE kessai_seq SET seq = '.$cur_num.' ');
		$stt->execute();
		$db = NULL;
	} catch (PDOException $e) {
		die($e->getMessage());
	}
	//Sid number
	$dat_sid = $dat_id.substr('000000'.strval($cur_num),-6);
	
	
	//update Sid number in user data
	try {
		//connect to database
		$db = connexion_database ();
		
		$stt = $db->prepare('UPDATE memlist SET sid = "'.$dat_sid.'" WHERE id="'.$dat_id.'" ');
		$stt->execute();
		$db = NULL;
	} catch (PDOException $e) {
		die($e->getMessage());
	}
		
?>    
    <div data-role="page" id="step4" class="jquery">
    
        <div id="header-box">
            <h1>メンバー登録</h1>
        </div><!-- /header -->
        
        <div data-role="content" data-theme="b">
         	<h2>STEP 4</h2>
            <h3>メンバー登録料のお支払手続きをお願いします </h3>
            <p> メールアドレスの確認ができました。<br />引き続き、登録料のお支払手続きに入ります。お支払方法を選択してください。</p>
        
			<div data-role="fieldcontain" class="div-form-s4">    
                 <p>
                    【クレジットカードでお支払の場合】<br/>
                当協会ではクレジットカードをご利用の場合、株式会社デジタルチェックのシステムを利用しております。
                以下の「クレジットカードでお支払」のボタンをクリックして、支払手続きをお願いいたします。<br />
                <b>クレジットカードでのお支払には SSLというシステムを利用しており、カード番号等の情報は暗号化されて送信されます。ご安心下さい。また、ご入力頂きますクレジットカード番号、有効期限等の情報は、今回の決済にのみ利用され、当協会のシステムには保存されません。</b>
                </p>
				<?php
				if(isset($_GET['payment']) || $dat_state == 5 || $dat_state == 9 )
				{
					?>
					<div class="titlebar">
						<p>
                        <?php 	if($_GET['payment']=='error')
									echo 'カードでのお支払処理時にエラーが発生しました。<br/>カード番号及び有効期限の入力に誤りがあるか、ご利用頂けないカード番号です。<br/>お手数ですが詳細は、toiawase@jawhm.or.jpまでお問い合わせください。<br/>';
								else
									echo '既にお支払手続きが完了しております。';
						?>
									
                        </p>
					</div>
                    <br />
				<?php
				}
					?>

                <div id="cb_logo"></div>
                <p class="msg_error">
                    &nbsp;<br/>
                    【ご注意】<br/>
                    クレジットカードでお支払の場合、ＶＩＳＡ（ビザ）又はＭＡＳＴＥＲ（マスター）のマークがあるカードのみご利用頂けます。<br/>
                </p>
                <div>
                    <form method="POST" action="payment.php" data-ajax="false" accept-charset="Shift_JIS" onsubmit="document.charset='SHIFT-JIS';"> 
                        <input type="hidden" name="IP" value="A363045858" />
                        <input type="hidden" name="SID" value="<?php echo $dat_sid; ?>" />
                        <input type="hidden" name="N1" value="JAWHM MEMBERSHIP FEE" />
                        <input type="hidden" name="K1" value="5000" />
                        <input type="hidden" name="FUKA" value="<?php echo $dat_id; ?>" />
                        <input type="hidden" name="KAKUTEI" value="1" />
                        <input type="hidden" name="STORE" value="51">
                        <input type="hidden" name="OKURL" value="<?php echo $ok_url_payment;?>" />
                        <input type="hidden" name="RT" value="<?php echo $wrong_url_payment;?>" />
                        <input type="hidden" name="NAME1" value="<?php echo $dat_name1; ?>" />
                        <input type="hidden" name="NAME2" value="<?php echo $dat_name2; ?>" />
                        <input type="hidden" name="TEL" value="<?php echo $dat_tel; ?>" />
                        <input type="hidden" name="ADR1" value="<?php echo $dat_adr1; ?>" />
                        <input type="hidden" name="ADR2" value="<?php echo $dat_adr2; ?>" />
                        <input type="hidden" name="MAIL" value="<?php echo $dat_email; ?>" />
                        <input type="hidden" name="state" value="<?php echo $dat_state; ?>" />
                        <input type="hidden" name="form" value="cb" />
                        <input type="submit" value="クレジットカードでお支払" data-icon="arrow-r" /><br />
                    </form>
			<br />
                </div>
            </div>

			<div data-role="fieldcontain" class="div-form-s4">
                <p>
                    【コンビニでお支払の場合】<br/>
                    当協会ではコンビニ支払をご利用の場合、株式会社デジタルチェックのシステムを利用しております。
                    以下からお好きなコンビニを選択し、「コンビニでお支払」のボタンをクリックして、支払手続きをお願いいたします。<br/>
                </p>
                <p class="msg_error">
                    &nbsp;<br/>
                    【ご注意】<br/>
                    決済手数料（218円）はお客様のご負担となります。（コンビニ店頭で、5,218円をお支払下さい。）<br/>
                    また、コンビニ端末で、事業所名に「株式会社デジタルチェック」と表示される場合がありますが、問題ありません。<br/>
                    株式会社デジタルチェックは、メンバー登録料の収納代行会社の名前です。<br/>
                </p>
                
                <p><br />ご希望のコンビニエンス・ストアをお選びください。</p>
                
                <div data-role="fieldcontain" id="choice-conbini">
                <?php
					//show error  
					if($_GET['store']=='none')
						echo'<div class="titlebar"><p><strong>コンビニエンス・ストアが選択されていません。</strong></p></div><br />'; 
				?>
                <form method="POST" action="payment.php" data-ajax="false" accept-charset="Shift_JIS" onsubmit="document.charset='SHIFT-JIS';">
                    <input type="hidden" name="IP" value="D363045858">
                    <input type="hidden" name="SID" value="<? echo $dat_sid; ?>" />
                    <input type="hidden" name="NAME1" value="<? echo $dat_name1.$dat_name2; ?>" />
                    <input type="hidden" name="NAME2" value="　" />
                    <input type="hidden" name="TEL" value="<? echo $dat_tel; ?>" />
                    <input type="hidden" name="ADR1" value="<? echo $dat_adr1; ?>" />
                    <input type="hidden" name="MAIL" value="<? echo $dat_email; ?>" />
                    <input type="hidden" name="FUKA" value="<? echo $dat_id; ?>" />
                    <input type="hidden" name="N1" value="日本ワーキングホリデー協会登録料" />
                    <input type="hidden" name="K1" value="5218" />
                    
                    <fieldset data-role="controlgroup" data-type="horizontal" >
                            <input type="radio" name="STORE" id="lawson" value="1"/>
                            <label for="lawson" id="label_lawson"></label>
               
                            <input type="radio" name="STORE" id="threef" value="73" />
                            <label for="threef" id="label_threef"></label>
                
                            <input type="radio" name="STORE" id="circleK" value="73" />
                            <label for="circleK" id="lable_circleK"></label>
                             
                            <input type="radio" name="STORE" id="dailyyamazaki" value="73" />
                            <label for="dailyyamazaki" id="label_dailyyamazaki"></label>

                            <input  type="radio" name="STORE" id="yamazakidaily" value="73" />
                            <label for="yamazakidaily" id="label_yamazakidaily" ></label>
                           
                            <input type="radio" name="STORE" id="familymart" value="3" />
                            <label for="familymart" id="label_familymart"></label>
                
                            <input type="radio" name="STORE" id="ministop" value="1" />
                            <label for="ministop" id="label_ministop"></label>
                                                       
                            <input type="radio" name="STORE" id="seicomart" value="1" />
                            <label for="seicomart" id="label_seicomart"></label>
                
                            <input type="radio" name="STORE" id="seven" value="2" />
                            <label for="seven" id="label_seven"></label>
                    </fieldset> 
                    <br />
                    <input type="hidden" name="TAX" value="238" />        
                    <input type="hidden" name="form" value="conv" />
                    <input type="submit" value="コンビニでお支払" data-icon="arrow-r" />
                </form>
                    
                </div>
            </div>
            
            <div data-role="fieldcontain" class="div-form-s4">
                <p>
                    【銀行振込でお支払の場合】<br/>
                    銀行振込で登録料をお支払の場合、以下の口座をご利用ください。<br/>
                    なお、１週間以内にお振込をお願い致します。
                </p>

                <div id="hurikomi_logo"></div>
                <div class="infolist">
                	<span class="label_infolist">銀行名</span>:<span class="text_infolist">三井住友銀行 (0009)</span><br />
                	<span class="label_infolist">支店名</span>:<span class="text_infolist">新宿支店 (221)</span><br />
                	<span class="label_infolist">口座番号</span>:<span class="text_infolist">普通　4246817</span><br />
                	<span class="label_infolist">名義人</span>:<span class="text_infolist">シャ）ニホンワーキングホリデーキョウカイ</span><br />
                </div>
                <p class="msg_error">
                    &nbsp;<br/>
                    【ご注意】<br/>
                    お振込手数料はお客様のご負担となります。<br/>手数料は振込方法により異なりますので、取引銀行にお問い合わせください。
                </p>
                <div>
                    <form name="step4-hurikomi" method="post" action="check.php" data-ajax="false">
                        <input type="hidden" name="step" value="4" />
                        <input type="hidden" name="userid" value="<? echo $dat_id; ?>" />
                        <input type="hidden" name="email" value="<? echo $dat_email; ?>" />
                        <input type="hidden" name="target" value="furikomi" />
                        <input type="submit" value="銀行振込でお支払" data-icon="arrow-r" />
                    </form>
			<br />
                </div>
            </div>
            
            
        </div><!-- /content -->
        
       <?php echo footer(); ?>
         
    </div>