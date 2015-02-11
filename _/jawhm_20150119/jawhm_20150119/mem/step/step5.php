<?php
	if ($abort)	
	{
			// エラー発生
		?>
        <div style="padding-left:30px; font-size:12pt;">
            <p>&nbsp;</p>
            <p style="border:2px dotted navy; padding:10px 20px 10px 20px; margin:10px 50px 10px 0;">
                <?php echo $abort_msg; ?>
            </p>
            <p>&nbsp;</p>
            <p>
                <a href="./register.php?k=<?php echo $k; ?>">メンバー登録を最初からやり直す場合は、こちらからどうぞ</a><br/>
            </p>
        
        </div>
        
<?php
    }
	else
	{
                    // 通常画面
        ?>
        
        <div style="padding-left:30px; margin-bottom:80px;">
            <p class="title_bar">
        <?php
            if ($dat_tgt == 'card' && $cur_state == '1')
                print 'メンバー登録料のお支払手続きをお願いいたします。';
            else
                print 'メンバー登録ありがとうございました。';
        ?>
            </p>
            <p>
                <?php echo $msg; ?>
            </p>
        <?php
            if ($dat_tgt == 'card' && $cur_state == '1')	
			{
				
            }
			else
			{
        ?>
                <p style="margin-top:10px; font-size:12pt;">
                    <a href="/">それでは、ワーホリの準備を始めましょう！！</a><br/>
                </p>
        
			<?php
                if ($k <> '')	
				{
			?>
                    <div style="margin:20px 20px 20px 0px; padding:10px 20px 10px 20px; border:3px dotted navy; font-size:14pt; font-weight:bold;">
                        メンバー登録手続きが完了しました。<br/>
                        恐れ入りますが、お近くのスタッフまでお声かけください。<br/>
                    </div>
			<?php
                    echo $dat_id.'　';
                    switch($dat_tgt)	
					{
                        case 'card':
                            echo 'カード払い';
                            break;
                        case 'conv':
                            echo 'コンビニ決済';
                            break;
                        case 'furikomi':
                            echo '銀行振込';
                            break;
                    }
                }
            }
        		?>
        </div>
        
<?php
	}
		?>