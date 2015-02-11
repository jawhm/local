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

			<?php


	// ＩＰチェック
	$ip_acc = $_SERVER["REMOTE_ADDR"];
	$shinjuku = gethostbynamel('shinjuku-office.jawhmnet.com');
	$osaka = gethostbynamel('osaka-office.jawhmnet.com');
	$nagoya = gethostbynamel('nagoya-office.jawhmnet.com');
	$fukuoka = gethostbynamel('fukuoka-office.jawhmnet.com');
//	$ip_base = $host[0];

	if ($ip_acc == $shinjuku[0] || $ip_acc == $osaka[0] || $ip_acc == $nagoya[0] || $ip_acc == $fukuoka[0])	{
//                if ($k <> '')		{
			?>
                    <div style="margin:20px 20px 20px 0px; padding:10px 20px 10px 20px; border:3px dotted navy; font-size:16pt; font-weight:bold;">
                        メンバー登録手続きが完了しました。<br/>
                        恐れ入りますが、お近くのスタッフまでお声かけください。<br/>
                    </div>
			<?php
			echo '<div style="margin:30px 0 10px 0; padding:20px 10px 20px 10px;">';
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

			echo '<hr/>';
			echo '&nbsp;<br/>';
			echo '<input type=button value="　　仮　カ　ー　ド　　" onclick="window.open(\'http://www.jawhm.or.jp/mailsystem/mem/data/mem/precard/'.$dat_id.'\', \'_blank\', \'width=990,height=800\');return false;">';
			echo '　　　';
			echo '<input type=button value="　　Ｐ　Ｗ　Ｄ　　" onclick="window.open(\'http://www.jawhm.or.jp/mailsystem/mem/data/mem/repwd/'.$dat_id.'\', \'_blank\', \'width=990,height=800\');return false;">';
			echo '　　　';
			echo '';
			if ($dat_tgt == 'conv')	{
				echo '<input type=button value="　　コ　ン　ビ　ニ　　" onclick="window.open(\''.$cur_payment_url.'\', \'_blank\', \'width=990,height=800\');return false;">';
				echo '　　　';
			}
			if ($dat_tgt == 'card')	{
				echo '<input type=button value="　　カ　ー　ド　　" onclick="window.open(\'http://www.jawhm.or.jp/mailsystem/mem/data/mem/card2/'.$dat_id.'\', \'_blank\', \'width=990,height=800\');return false;">';
				echo '　　　';
			}
			echo '';
			echo '</div>';

                }else{
			?>
                <p style="margin-top:10px; font-size:12pt;">
                    <a href="/">それでは、ワーホリの準備を始めましょう！！</a><br/>
                </p>
			<?php
		}
            }
        		?>
        </div>
        
<?php
	}
		?>