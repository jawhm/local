    
	<div style="padding-left:30px;">
		<p class="title_bar">
			入力頂いた内容を確認の上、よろしければ「次へ」をクリックしてください。
		</p>
	
		<table style="font-size:11pt;" border="1" bordercolor="navy">
			<tr>
				<td class="td_check_tag">メールアドレス</td>
				<td class="td_check_input" width="400"><?php echo $dat_email; ?></td>
			</tr>
			<tr>
				<td class="td_check_tag">お名前</td>
				<td class="td_check_input"><?php echo $dat_namae; ?></td>
			</tr>
			<tr>
				<td class="td_check_tag">フリガナ</td>
				<td class="td_check_input"><?php echo $dat_furigana; ?></td>
			</tr>
			<tr>
				<td class="td_check_tag">性別</td>
				<td class="td_check_input">
					<?php if ($dat_gender == 'm')	{ echo '男性'; } else { echo '女性'; }	?>
				</td>
			</tr>
			<tr>
				<td class="td_check_tag">生年月日</td>
				<td class="td_check_input">
					<?php echo $dat_year.'年 '.$dat_month.'月 '.$dat_day.'日'; ?>
				</td>
			</tr>
			<tr>
				<td class="td_check_tag">現住所</td>
				<td class="td_check_input">
					<table>
					<tr>
						<td>郵便番号</td>
						<td>　　<?php echo $dat_pcode; ?></td>
					</tr>
					<tr>
						<td>都道府県</td>
						<td>　　<?php echo $dat_add1; ?></td>
					</tr>
					<tr>
						<td>市区町村</td>
						<td>　　<?php echo $dat_add2; ?></td>
					</tr>
					<tr>
						<td>番地・建物名</td>
						<td>　　<?php echo $dat_add3; ?></td>
					</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td class="td_check_tag">電話番号</td>
				<td class="td_check_input"><?php echo $dat_tel; ?></td>
			</tr>
			<tr>
				<td class="td_check_tag">職業</td>
				<td class="td_check_input"><?php echo $dat_job; ?></td>
			</tr>
			<tr>
				<td class="td_check_tag">渡航予定国</td>
				<td class="td_check_input"><?php echo $dat_country; ?></td>
			</tr>
			<tr>
				<td class="td_check_tag">渡航予定国の語学力</td>
				<td class="td_check_input"><?php echo $dat_gogaku; ?></td>
			</tr>
			<tr>
				<td class="td_check_tag">渡航目的</td>
				<td class="td_check_input"><?php echo $dat_purpose; ?></td>
			</tr>
			<tr>
				<td class="td_check_tag">どこで当協会を知りましたか</td>
				<td class="td_check_input"><?php echo $dat_know; ?></td>
			</tr>
			<tr>
				<td class="td_check_tag">今後のご案内</td>
				<td class="td_check_input">
					<?php if ($dat_mailsend == '1') { echo '受け取る'; } else { echo '受け取らない'; }	?>
				</td>
			</tr>
		</table>
	
	<form class="cmxform" id="signupForm" method="post" action="./confirm.php?k=<?php echo $k; ?>">
		<input type="hidden" name="act" value="<?php echo $act; ?>">
		<input type="hidden" name="kyoten" value="<?php echo $dat_kyoten; ?>">
		<input type="hidden" name="email" value="<?php echo $dat_email; ?>">
		<input type="hidden" name="password" value="<?php echo $dat_password; ?>">
		<input type="hidden" name="namae" value="<?php echo $dat_namae; ?>">
		<input type="hidden" name="furigana" value="<? echo $dat_furigana; ?>">
		<input type="hidden" name="gender" value="<?php echo $dat_gender; ?>">
		<input type="hidden" name="year" value="<?php echo $dat_year; ?>">
		<input type="hidden" name="month" value="<?php echo $dat_month; ?>">
		<input type="hidden" name="day" value="<?php echo $dat_day; ?>">
		<input type="hidden" name="pcode" value="<?php echo $dat_pcode; ?>">
		<input type="hidden" name="add1" value="<?php echo $dat_add1; ?>">
		<input type="hidden" name="add2" value="<?php echo $dat_add2; ?>">
		<input type="hidden" name="add3" value="<?php echo $dat_add3; ?>">
		<input type="hidden" name="tel" value="<?php echo $dat_tel; ?>">
		<input type="hidden" name="job" value="<?php echo $dat_job; ?>">
		<input type="hidden" name="country" value="<?php echo $dat_country; ?>">
		<input type="hidden" name="gogaku" value="<?php echo $dat_gogaku; ?>">
		<input type="hidden" name="purpose" value="<?php echo $dat_purpose; ?>">
		<input type="hidden" name="know" value="<?php echo $dat_know; ?>">
		<input type="hidden" name="mailsend" value="<?php echo $dat_mailsend; ?>">
		<input type="hidden" name="agree" value="<?php echo $dat_agree; ?>">
	
	<input type="button" class="back" value="<< 戻る" onclick="history.back();" style="width:150px; height:30px; margin:18px 0 10px 20px; font-size:11pt; font-weight:bold;">
<?php	if ($chk == 'ok')	{	?>
	<input type="submit" class="submit" value="次へ >>" style="width:150px; height:30px; margin:18px 0 10px 0; font-size:11pt; font-weight:bold;">
<?php	}	?>
	</form>
	
	</div>