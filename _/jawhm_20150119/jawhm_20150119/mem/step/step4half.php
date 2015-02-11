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

    <div style="padding-left:30px;">
		<p class="title_bar">
			<?php 
                if($card_process == 'OK')
                    echo 'クレジットカード情報を入力してください。';
                elseif($conbini_process == 'OK')
                    echo 'コンビニでのお支払をお願いいたします。';
            ?>
		</p>
		<div>
			<?php if($card_process == 'OK')
            { 
				if($payment_error == 'card-error') //card payment error;
				{
					$msg_payment = 'カード番号を正しく入力してください。<br/>';
					echo '<p class="orange_info">'.$msg_payment.'</p>';
				}
			?>
            <p>メンバー登録料をお支払頂く、クレジットカードの番号と有効期限を入力してください。<br /><br />
            <strong style="color:red;">【ご注意】<br />
            ＶＩＳＡ（ビザ）又はＭＡＳＴＥＲ（マスター）のマークがあるカードのみご利用頂けます</strong>
            </p>
            <?php
            }?>
			<div class="frame">
					<?php
						//Process for CARD (the expired date is treated by Jquery code before sending the form)
						//----------------
						if($card_process == 'OK')
						{
					?>
                    
                    <form id="payment" method="POST" action="https://www.digitalcheck.jp/settle/settle3/credit/settle_cr_cpt25.do">
                        <input type="hidden" name="settle_req_crypt" value="<?php echo $_SESSION['request_code']; ?>" />
                        <input type="hidden" name="settle_seq" value="<?php echo $_SESSION['resquest_sequence']; ?>" />

                        <table class="payment-process">
                            <tr>
                                <td class="label-payment">お支払い金額</td>
                                <td><strong>5,000円</strong></td>
                            </tr>
                            <tr>
                            	<td class="label-payment">ご利用頂けるカードブランド</td>
                                <td><img src="images/creditcard_rogo.gif" width="303" height="37" /></td>
                            </tr>
                            <tr>
                            	<td class="label-payment">クレジットカード番号</td>
                                <td><input type="number" name="CARDNO" size="20" maxlength="16" class="focus" />&nbsp;<small><strong>（ハイフンなし)</strong></small><br/><small style="color:#999999;display:block;width:10px;padding-left:50px;">例）9876543210123456
</small></td>
                            </tr>
                            <tr>
                            	<td class="label-payment">有効期限</td>
                                <td><select id="month" name="month">
                                	<?php
										for($i=1;$i<=12;$i++)
										{
											if($i<10)
												$i='0'.$i;

											echo '<option value="'.$i.'">'.$i.'</option>';	
										}
									?>
                                	</select>&nbsp;&frasl;&nbsp;
									<select id="year" name="year">
                                	<?php
										for($i=date('Y');$i<(date('Y')+6);$i++)
										{
											echo '<option value="'.substr($i, -2).'">'.$i.'</option>';	
										}
									?>
                                	</select>                                
                                </td>
                            </tr>
                            </table>
                        	
                            <div class="middle">	
                                <input type="hidden" value="" name="EXP" size="8" maxlength="4" class="focus" />
                                <input id="btncheck" class="orange-btn" type="submit" value="お支払い" />
                                <p class="payment-info">
                                <strong style="color:red;">処理には数秒かかることがございます。<br/>
                                二重決済を防ぐため「お支払い」ボタンは２回以上押さないようにお願い致します。<br /></strong>
                                <strong>ブラウザの戻るボタンや更新ボタンもご利用しないようにお願い致します。</strong>
                                </p>
                                <p class="btn-back">
                                <input  type="button" class="send_btn_small" value="決済を中止して前の画面に戻る" onclick="history.back();" />
                                </p>
                            </div>
						</form>
					<?php	
						}
						?>
						
					<?php
						//Process for conbini
						//----------------
						if($conbini_process == 'OK')
						{ 
					?>	
                            <table class="payment-process">
                                <tr>
                                    <td class="label-payment">お支払い金額</td>
                                    <td><strong><?php echo $k1; ?>円</strong><br /><small style="color:red;">（決済手数料（お客様負担） 218円が含まれています。）
</small></td>
                                </tr>
                                <tr>
                                    <td class="label-payment">受付番号・払込票番号</td>
                                    <td><span id="payment-nb"><?php echo $payment_number; ?></span><input class="btn-blue" type="button" value="詳細表示" onclick="window.open('<?php echo urldecode($url);?>');" /></td>
                                </tr>
                                <tr>
                                    <td class="label-payment">クレジットカード番号</td>
                                    <td><?php 
											//display date of use as yyyy年ｍｍ月ｄｄ日
											$exp_year = substr($date_of_use, 0,4).'年';
											$exp_month = substr($date_of_use, -4,-2).'月';
											$exp_day = substr($date_of_use, -2).'日';
											echo $exp_year.$exp_month.$exp_day;
										?></td>
                                </tr>
                             </table>
                             
                          	 <form name="conbini-payment" method="post" action="payment.php">
                             
								<input type="hidden" name="tgt" value="conv" />
								<input type="hidden" name="email" value="<?php echo $MAIL; ?>" />
								<input type="hidden" name="userid" value="<?php echo $FUKA; ?>" />
								<input type="hidden" name="payment_nb" value="<?php echo $payment_number; ?>" />
								<input type="hidden" name="expired_date" value="<?php echo $date_of_use; ?>" />
								<input type="hidden" name="payment_url" value="<?php echo urldecode($url); ?>" />
								<input type="hidden" name="act" value="4" />

                                <div class="middle">	
                                    <input class="orange-btn" type="submit" value="内容を確認しました" />
                                    <p class="payment-info">
                                    	<strong style="color:red;">上記の「受付番号・払込票番号」は、<br />お支払時に必要になりますので必ずお控えください</strong>
                                    </p>
                                    <p class="btn-back">
                                    <input  type="button" class="send_btn_small" value="前の画面に戻る" onclick="history.back();" />
                                    </p>
                                </div>
							</form>
					<?php	
						}
						
						if($return_state == 'PRERROR' || $return_state == 'ERROR' )
						{
							//echo 'IP '.$IP.'<br />SID '.$SID.'<br /> N1 '.$N1. '<br /> K1 '.$K1. '<br /> FUKA '.$FUKA. '<br /> STORE '.$STORE. ' <br />TAX '.$STORE.'<br /> NAME1 '.$NAME1. ' <br />NAME2 '.$NAME2. ' <br />TEL '.$TEL.' <br />ADR1 '.$ADR1.' <br />ADR2 '.$ADR2.'<br /> MAIL '.$MAIL;
							echo '<p class="orange_info">'.mb_convert_encoding($result, "UTF-8", "SJIS").'</p>';
							echo '<input type=button class="send_btn_small" value="<< 戻る" onclick="history.back();" />';
						}
						
						?>


			</div>
		</div>
	</div>
