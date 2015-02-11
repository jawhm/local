<?php

mb_language("Ja");
mb_internal_encoding("utf8");

	require_once('./include/mem_function.php');

	/******************************/
	/***      Cache  limiter  *****/
	
	session_cache_limiter('private_no_expire'); 
	session_start();
	
	/******************************/
	/*  ERROR FROM CARD PAYMENT   */
	/******************************/
	
	if(isset($_GET['ERROR'])):
		
		$id = $_GET['FUKA'];
		//$error = $_GET['ERROR']; 
		
		//redirection
		header("location:member_form.php?return=step4&id=".$id."&payment=error");
		exit;		

		
	endif;
		
	/******************************/
	/*    Payment by card         */
	/******************************/
			
	if(isset($_POST['form']) && $_POST['form']=='cb'):
	
		//check state first 5 or 9 is WRONG
		$state = $_POST['state'];
		
		if($state == 5 || $state == 9)
		{
			$id = $_POST['FUKA'];
			
			//redirection
			header("location:member_form.php?return=step4&id=".$id."&payment=paid");
			exit;		
		}
		
		
		//create array with list of parameter
		$list_param = array('IP', 'SID', 'N1', 'K1', 'FUKA','KAKUTEI', 'STORE', 'OKURL', 'RT', 'NAME1', 'NAME2', 'TEL', 'ADR1', 'ADR2', 'MAIL');

		//===================================
		//gather all information in an array
		//==================================

		foreach($list_param as $param)
		{
			$$param = $_POST[$param];
			$final_array[$param] = $$param;
		}
		
		//display debug array
		//echo debug_array($final_array);
		
		//$url = 'http://192.168.11.95:8083/test-michael/collect_box.php';
		$url2 = 'https://www.digitalcheck.jp/settle/settle2/ubp25.dll';
	
		
		// POST SEND
		$final_array = http_build_query($final_array);
		$opts = array( 'http' => array(
										'method'  => 'POST',
										'header'  => 'Content-type: application/x-www-form-urlencoded;charset=Shift_JIS',
										//'header'  => 'Content-type: text/plain;charset=Shift_JIS',
										'content' => $final_array
										)
						);
		$context  = stream_context_create($opts);
		
		//get result
		$result = file_get_contents($url2, false, $context);
		//echo $result;
		
		//make visible what's between each data -> %0D%0A
		$encode_result= urlencode($result);
		//echo '<p>'.$encode_result.'</p>';
		
		//treat result
		list($return_state) = split('%0D%0A', $encode_result);
		//echo '<p>$return_state= '.$return_state.'</p>';
				
		//check if correct
		if($return_state == 'OK') :
			//echo 'IN';
			list($card_process, $sid, $k1, $request_code, $resquest_sequence, $fuka, $blank) = split('%0D%0A', $encode_result);
			//echo $cb_process.' - '.$sid.' - '.$k1.' - '.$request_code.' - '.$resquest_sequence.' - '.$fuka.' - '.$blank;
									
		elseif($return_state == 'PRERROR' || $return_state == 'ERROR' ):
			//echo 'OUT';
			echo $result;
		endif;
		
	endif;	
	
	/******************************/
	/*    Payment by conbini      */
	/******************************/
	
	
	if(isset($_POST['form']) && $_POST['form']=='conv'):
	
		//create array with list of parameter
		$list_param = array('IP', 'SID', 'N1', 'K1', 'FUKA', 'STORE', 'TAX', 'NAME1', 'NAME2', 'TEL', 'ADR1', 'ADR2', 'MAIL');
		
		//===================================
		//gather all information in an array
		//==================================

		foreach($list_param as $param)
		{
			$$param = $_POST[$param];
			$final_array[$param] = $$param;
		}
		
		//Check if the user hase chosen a convenience store
		if(empty($STORE)):
			header('location:member_form.php?return=step4&id='.$FUKA.'&store=none');
			exit;
		endif;
		
		//display debug array
		//echo debug_array($final_array);
		
		$url = 'https://www.digitalcheck.jp/settle/settle2/ubp3.dll';
	
		
		// POST SEND
		$final_array = http_build_query($final_array);
		$opts = array( 'http' => array(
										'method'  => 'POST',
										'header'  => 'Content-type: application/x-www-form-urlencoded;charset=Shift_JIS',
										//'header'  => 'Content-type: text/plain;charset=Shift_JIS',
										'content' => $final_array
										)
						);
		$context  = stream_context_create($opts);
		
		//get result
		$result = file_get_contents($url, false, $context);
		//echo $result;
				
		//make visible what's between each data ->%0D%0A
		$encode_result=  urlencode($result);
		//echo '<p>'.$encode_result.'</p>';
		
		//treat result
		list($return_state) = split('%0D%0A', $encode_result);
		//echo '<p>$return_state= '.$return_state.'</p>';
		
		//check if correct
		if($return_state == 'OK') :
			//echo 'IN';
			list($conbini_process, $sid, $k1, $payment_number, $date_of_use, $fuka, $url) = split('%0D%0A', $encode_result);
			//echo $conbini_process.' - '.$sid.' - '.$k1.' - '.$payment_number.' - '.$date_of_use.' - '.$fuka.' - '.urldecode($url);
						
		elseif($return_state == 'PRERROR' || $return_state == 'ERROR' ):
			//echo 'OUT';
			echo mb_convert_encoding($result, "UTF-8", "SJIS");			
			echo '<br />'.$result;
		endif;
		
	endif;	
	
	/************************/

	//HEADER
	require_once('include/header.php');
	
	//Process for CARD
	if($card_process == 'OK'): 
?>
    <script type="text/javascript">
      jQuery().ready(function(){ 
          jQuery("#btncheck").click(function() { 
		  var gatsu	= jQuery("select#month").val(); 
          var nen	=jQuery("select#year").val(); 
          var expired = nen+gatsu;
			jQuery("input[name=EXP]").val(expired);	
          });  
        });					
    </script>

        <div data-role="page" id="payment-process" class="jquery">
        
            <div id="header-box">
                <h1>メンバー登録</h1>
            </div><!-- /header -->
               
            <div data-role="content" data-theme="b">
                <h2>STEP 4</h2>
                <h3>クレジットカード情報を入力してください。</h3>
                
                <form method="POST" action="https://www.digitalcheck.jp/settle/settle3/credit/settle_cr_cpt25.do" data-ajax="false">
                    <input type="hidden" name="settle_req_crypt" value="<?php echo $request_code; ?>" />
                    <input type="hidden" name="settle_seq" value="<?php echo $resquest_sequence; ?>" />
                
                <div data-role="fieldcontain" class="div-form">    
                    <span class="listing-title">お支払い金額</span>
					<p>５，０００円</p>
                </div>
                
                <div data-role="fieldcontain" class="div-form">    
                    <span class="listing-title">ご利用頂けるカードブランド</span><br />
					<img src="css/images/visa-card.png" title="creditcard" />
                </div>
                
                <div data-role="fieldcontain" class="div-form">    
                    <span class="listing-title">クレジットカード番号</span><br />
                    <input type="number" name="CARDNO" size="20" maxlength="16" data-mini="true"  placeholder="例）9876543210123456" /><br />
			<p>ご注意：ハイフンは入力しないでください。</p>
                </div>
                
                <div data-role="fieldcontain" class="div-form">    
                    <span class="listing-title">有効期限</span><br />
                       <fieldset data-role="controlgroup" data-type="horizontal">
                            <select id="month" name="month" data-mini="true">
                            <?php
                                for($i=1;$i<=12;$i++)
                                {
                                    if($i<10)
                                        $i='0'.$i;

                                    echo '<option value="'.$i.'">'.$i.'</option>';	
                                }
                            ?>
                            </select>    
                            <select id="year" name="year" data-mini="true">
                            <?php
                                for($i=date('Y');$i<(date('Y')+10);$i++)
                                {
                                    echo '<option value="'.substr($i, -2).'">'.$i.'</option>';	
                                }
                            ?>
                            </select>                                
                        </fieldset> 
                    
                    <input type="hidden" name="EXP" size="8" maxlength="4" data-mini="true" /><br />
                    <a href="" type="button" data-theme="b" data-icon="back" data-rel="back" data-inline="true" />戻る</a>
                    <input id="btncheck" type="submit" value="お支払い" data-theme="e" data-icon="check" data-inline="true" /><br />
                                <strong style="color:red;">処理には数秒かかることがございます。<br/>
                                二重決済を防ぐため「お支払い」ボタンは２回以上押さないようにお願い致します。<br /></strong>
                                <strong>ブラウザの戻るボタンや更新ボタンもご利用しないようにお願い致します。</strong>
                 </div>
                 </form>
            </div><!-- /content -->
            
		   <?php echo footer(); ?>
             
        </div>
        
<?php	
	endif;
	
	//Process for conbini
	if($conbini_process == 'OK'):

?>
       <div data-role="page" id="payment-process" class="jquery">
        
            <div id="header-box">
                <h1>メンバー登録</h1>
            </div><!-- /header -->
                
            <div data-role="content" data-theme="b">
                <h2>STEP 4</h2>
                <h3>コンビニでのお支払をお願いいたします。</h3>

		<p>
		コンビニでのお支払時に、以下の受付番号・払込番号が必要となります。<br/>
		この番号はメールでもご案内しておりますが、<br />念のために、この画面を画面キャプチャ（スクリーンショット）しておくことをお薦め致します。
		</p>

                <div data-role="fieldcontain" class="div-form">
                        <span class="listing-title">お支払い金額</span>
                        <p><?php echo mb_convert_kana(number_format($k1), 'A'); ?>円</p>
                </div>
                <div data-role="fieldcontain" class="div-form">
                        <span class="listing-title">受付番号・払込票番号</span>
                        <p><?php echo mb_convert_kana($payment_number, 'A'); ?><a href="<?php echo urldecode($url); ?>" type="button" data-theme="c" data-icon="check" data-inline="true" target="_new" />詳細表示</a></p>
			<p>コンビニでのお支払時に必要な番号になります。</p>
                </div>
                <div data-role="fieldcontain" class="div-form">
                        <span class="listing-title">お支払い期限</span>
                        <p><?php 
								//display date of use as yyyy年ｍｍ月ｄｄ日
								$exp_year = substr($date_of_use, 0,4).'年';
								$exp_month = substr($date_of_use, -4,-2).'月';
								$exp_day = substr($date_of_use, -2).'日';
								echo mb_convert_kana($exp_year.$exp_month.$exp_day, 'A');
							?></p>
                </div>
                    
                <div data-role="fieldcontain" >
                    <form name="conbini-payment" method="post" action="check.php" data-ajax="false">
                        <input type="hidden" name="step" value="4" />
                        <input type="hidden" name="target" value="conv" />
                        <input type="hidden" name="email" value="<?php echo $MAIL; ?>" />
                        <input type="hidden" name="userid" value="<?php echo $FUKA; ?>" />
                        <input type="hidden" name="payment_nb" value="<?php echo $payment_number; ?>" />
                        <input type="hidden" name="expired_date" value="<?php echo $date_of_use; ?>" />
                        <input type="hidden" name="payment_url" value="<?php echo urldecode($url); ?>" />
                        <a href="" type="button" data-theme="b" data-icon="back" data-rel="back" data-inline="true" />戻る</a>
                        <input type="submit" value="内容を確認しました" data-theme="e" data-icon="check" data-inline="true" />
                    </form>
                </div>

            </div><!-- /content -->
            
		   <?php echo footer(); ?>
             
        </div>
<?php	

		//Get others sent data
		$dat_payment_nb = $payment_number;
		$dat_payment_url = urldecode($url);
		
		//make date format
		$year = substr($date_of_use, 0,4);
		$month = substr($date_of_use, -4,2);
		$day = substr($date_of_use, -2);
		
		$full_expired_date = $year.'-'.$month.'-'.$day;
		
		//update user data
		try
		{
			//connect to database
			$db = connexion_database ();
				
			$stt = $db->prepare('UPDATE memlist SET payment = "'.$target_type.'", payment_expired_date="'.$full_expired_date.'", payment_nb="'.$dat_payment_nb.'", payment_url="'.$dat_payment_url.'" WHERE id = "'.$FUKA.'"   ');
			$stt->execute();
			$db = NULL;
		} 
		catch (PDOException $e) 
		{
			die($e->getMessage());
		}
		
		
		// Send email
					
		//Mail to customer  OK
		$subject = "登録料のお支払についてのご案内です";
		$body  = '';
		$body .= '日本ワーキングホリデー協会です。';
		$body .= chr(10);
		$body .= 'メンバー登録ありがとうございます。';
		$body .= chr(10);
		$body .= chr(10);
		$body .= 'お選び頂きましたコンビニにてメンバー登録料のお支払をお願い致します。';
		$body .= chr(10);
		$body .= 'なお、コンビニでのお支払は以下のお支払期限までにお願い致します。';
		$body .= chr(10);
		$body .= chr(10);
		$body .= '受付番号・払込票番号：'.$dat_payment_nb;
		$body .= chr(10);
		$body .= '受付票・払込票表示：'.$dat_payment_url;
		$body .= chr(10);
		$body .= 'お支払期限：'.$full_expired_date;
		$body .= chr(10);
		$body .= chr(10);
		$body .= 'お支払が確認できましたら、ご登録の住所宛てに会員証をお送り致します。';
		$body .= chr(10);
		$body .= chr(10);
		$body .= 'また、コンビニ端末等に事業所名として「株式会社デジタルチェック」と表示される場合がありますが、';
		$body .= chr(10);
		$body .= 'こちらは当協会メンバー登録料の収納代行会社の名前ですので、問題ありません。ご安心下さい。';
		$body .= chr(10);
		$body .= chr(10);
		$body .= 'ご不明点などあれば、以下にご連絡ください。';
		$body .= chr(10);
		$body .= '電話番号：03-6304-5858';
		$body .= chr(10);
		$body .= 'メール：info@jawhm.or.jp';
		$body .= chr(10);
		$body .= '';			
		$from = mb_encode_mimeheader(mb_convert_encoding("日本ワーキングホリデー協会","JIS"))."<info@jawhm.or.jp>";
		mb_send_mail($MAIL,$subject,$body,"From:".$from);
					
		
		// 社内通知 OK

		$subject = "【メンバー登録：コンビニ決済予約】  ".$dat_namae."様  ".$dat_email;
		$body  = '';
		$body .= 'メンバー登録でコンビニ決済予約が発生しました。';
		$body .= chr(10);
		$body .= chr(10);
		$body .= '会員番号：'.$FUKA;
		$body .= chr(10);
		$body .= 'メールアドレス：'.$MAIL;
		$body .= chr(10);
		$body .= 'お名前：'.@$dat_namae;
		$body .= chr(10);
		$body .= 'フリガナ：'.@$dat_furigana;
		$body .= chr(10);
		$body .= '電話番号：'.@$dat_tel;
		$body .= chr(10);
		$body .= '受付番号・払込票番号：'.$dat_payment_nb; 
		$body .= chr(10);
		$body .= '受付票・払込票表示：'.$dat_payment_url; 
		$body .= chr(10);
		$body .= '有効期限：'.$full_expired_date;	
		$body .= '';
		$from = mb_encode_mimeheader(mb_convert_encoding($dat_namae,"JIS"))."<".$dat_email.">";
		
		//To admin
		mb_send_mail($mailadd,$subject,$body,"From:".$from);
		
		//To office
		mb_send_mail($mailoffice,$subject,$body,"From:".$from);

	endif;
	
	//FOOTER
	require_once('include/footer.php');

	
?>