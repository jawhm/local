	
	<?php	
	if ($k == '')	
	{	
		?>
    
        <div style="padding-left:30px;">
            <p class="title_bar">
                メールをご確認の上、承認コードを入力してください
            </p>
            <p>
                ご入力頂いたメールアドレス ( <?php echo $dat_email; ?> ) に、承認コードをお送りしました。<br/>
                メールをご覧になり、以下の内容を入力してください。<br/>
            </p>
            &nbsp;<br/>
            <p>
                なお、承認コードは「５桁の半角英数字」のコードです。
            </p>
    
        <?php
            if ($msg <> '')	
			{
                echo '<p class="orange_info">'.$msg.'</p>';
            }
        ?>
    
        <form class="cmxform" id="signupForm" method="post" action="./payment.php?k=<?php echo $k; ?>">
            <input type="hidden" name="act" value="<?php echo $act; ?>">
            <input type="hidden" name="userid" value="<?php echo $dat_id; ?>">
            <input type="hidden" name="email" value="<?php echo $dat_email; ?>">
            <table style="font-size:10pt; margin:20px 0 10px 20px;" border="0">
                <tr>
                    <td>承認コード　　</td>
                    <td>
                        <input id="mailcheck" name="mailcheck" maxlength="20" /><br/>
                    </td>
                </tr>
            </table>
            <input type="button" class="back" value="<< 戻る" onclick="history.back();" style="width:150px; height:30px; margin:18px 0 10px 20px; font-size:11pt; font-weight:bold;">
            <input type="submit" class="submit" value="次へ >>" style="width:150px; height:30px; margin:18px 0 10px 0; font-size:11pt; font-weight:bold;">
        </form>
        </div>
    <?php	
	}
	else
	{		
		?>
    
        <div style="padding-left:30px;">
            <p style="margin:20px 0 10px 0;">
                ご入力頂いたメールアドレス(　<?php echo $dat_email; ?>　)に、確認メールをお送りしました。<br/>
                &nbsp;<br/>
                下の「次へ」をクリックして、メンバー登録料のお支払方法を選択してください。<br/>
            </p>
    
        <?php
            if ($msg <> '')	
			{
                echo '<p class="orange_info">'.$msg.'</p>';
            }
        ?>
    
        <form class="cmxform" id="signupForm" method="post" action="./payment.php?k=<?php echo $k; ?>">
            <input type="hidden" name="act" value="<?php echo $act; ?>">
            <input type="hidden" name="userid" value="<?php echo $dat_id; ?>">
            <input type="hidden" name="email" value="<?php echo $dat_email; ?>">
            <input type="hidden" id="mailcheck" name="mailcheck" value="dummydata" maxlength="20" /><br/>
            <input type="button" class="back" value="<< 戻る" onclick="history.back();" style="width:150px; height:30px; margin:18px 0 10px 20px; font-size:11pt; font-weight:bold;">
            <input type="submit" class="submit" value="次へ >>" style="width:150px; height:30px; margin:18px 0 10px 0; font-size:11pt; font-weight:bold;">
	</form>
        </form>
        </div>
    
    <?php	
	}		
		?>
