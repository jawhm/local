<?php

// 一般メニュー読み込み
require 'php/fnc_menu.php';


if (count($param) > 2) {
	$data_param = $param[2];
}else{
	$data_param = 'main';
}

switch ($data_param)	{
	case "main":
		// カード手動決済
/*
		$body_title[] .= 'カード手動決済';
		$body[] .= '
			決済額を入力して「決済ページへ」ボタンを押してください。<br/>
			なお、カード決済にあたり、次の情報が必要です。<br/>
			　　・　クレジットカード番号<br/>
			　　・　カード有効期限<br/>
			　　・　カード名義人名<br/>
			　　・　電話番号<br/>
			&nbsp;<br/>
			<form method="post" action="https://linkpt.cardservice.co.jp/cgi-bin/order.cgi?orders" enctype="x-www.form-encoded" target="_blank">
				<input type="hidden" name="send" value="mail">
				<input type="hidden" name="clientip" value="2014000153">
				決済額：<input type="text" name="money" value="5000">
				<input type="hidden" name="custom" value="yes">
				<input type="hidden" name="usrtel" value="">
				<input type="hidden" name="usrmail" value="info@jawhm.or.jp">
				<input type="hidden" name="usrname" value="">
				<input type="hidden" name="sendid" value="manual">
				<input type="hidden" name="sendpoint" value="manual">
				<input type="submit" class="button_submit" value="決済ページへ">
			</form>
		';
*/

		try {
			$stt = $db->prepare('SELECT seq FROM kessai_seq');
			$stt->execute();
			$idx = 0;
			$cur_seq = '0';
			while($row = $stt->fetch(PDO::FETCH_ASSOC)){
				$idx++;
				$cur_seq = $row['seq'];
			}
			$cur_num = intval($cur_seq) + 1;
			$stt = $db->prepare('UPDATE kessai_seq SET seq = '.$cur_num.' ');
			$stt->execute();


		} catch (PDOException $e) {
			die($e->getMessage());
		}
		$dat_sid = 'M'.date('ymd').substr('000000'.strval($cur_num),-6);


		// ネット手動決済
		$body_title[] .= 'カード手動決済';
		$body[] .= '
			<script>
			function fncNetCard()	{
				if (jQuery("#netcard_form #money").val() == \'\')	{
					alert("決済額を入力してください。");
					jQuery("#netcard_form #money").focus();
					return false;
				}
				if (jQuery("#netcard_form #namae").val() == \'\')	{
					alert("お名前を入力してください。");
					jQuery("#netcard_form #namae").focus();
					return false;
				}
				if (jQuery("#netcard_form #youto").val() == \'\')	{
					alert("適用を入力してください。");
					jQuery("#netcard_form #youto").focus();
					return false;
				}

				if (confirm(\'カード手動決済用のＵＲＬを発行します。よろしいですか？\'))	{
					jQuery("#processing").show();
					jQuery.ajax({
						type: "POST",
						url: "'.$url_base.'data/zeus/netcard",
						data: jQuery("#netcard_form").serialize(),
						success: function(msg){
							jQuery("#processing").hide();
							jQuery("#res_net_card").html(msg);
							jQuery("#btn_request").attr("disabled", "disabled");
						},
						error:function(){
							jQuery("#processing").hide();
							alert("通信エラーが発生しました。");
						}
					});
				}
			}
			</script>

			以下を入力して「決済番号発行」ボタンを押してください。<br/>
			&nbsp;<br/>
			<form id="netcard_form" onsubmit="return false;">
				<table>
				<tr>
					<td>決済コード</td><td><input type="text" readonly name="sendid" value="'.$dat_sid.'"></td>
				</tr>
				<tr>
					<td>決済額</td><td><input type="text" name="money" id="money" value="" style="ime-mode:inactive;">(必須)　半角入力</td>
				</tr>
				<tr>
					<td>お名前</td><td><input type="text" name="namae" id="namae" value="" style="ime-mode:inactive;">(必須)　ローマ字入力（例：YAMADA TARO)</td>
				</tr>
				<tr>
					<td>適用</td><td><input type="text" name="youto" id="youto" value="" style="ime-mode:active;">(必須)　（例：カナダビザ申請セット販売）</td>
				</tr>
				<tr>
					<td>メモ</td><td><input type="text" name="memo" id="memo" value="" style="ime-mode:active;"></td>
				</tr>
				</table>
			</form>
			　<input type="button" onclick="fncNetCard();" id="btn_request" class="button_submit" value="決済番号発行">
			<div id="res_net_card" style="">
			</div>

		';

		break;

	case "payment":
		// メンバー登録料支払い（総合）（ＵＲＬ提示）

		$id = $param[3];

		try {
			$stt = $db->prepare('SELECT id, email, namae, tel, state, orderid, orderdate, mailcheck FROM memlist WHERE id = "'.$id.'"');
			$stt->execute();
			$idx = 0;
			while($row = $stt->fetch(PDO::FETCH_ASSOC)){
				$idx++;
				$cur_id = $row['id'];
				$cur_email = $row['email'];
				$cur_namae = $row['namae'];
				$cur_tel = $row['tel'];
				$cur_state = $row['state'];
				$cur_orderid = $row['orderid'];
				$cur_orderdate = $row['orderdate'];
				$cur_mailcheck = $row['mailcheck'];
			}
		} catch (PDOException $e) {
			die($e->getMessage());
		}

		$url = 'http://www.jawhm.or.jp/mem2/payment.php?act=s3&userid='.$cur_id.'&email='.$cur_email.'&mailcheck='.$cur_mailcheck;

		$body_title[] .= 'メンバー登録料支払い';
		$body[] .= '
			メンバー登録料支払選択ＵＲＬを表示します<br/>
			&nbsp;<br/>
			<table border="1">
			<tr><th width="100">会員番号</th><td>'.$cur_id.'</td><td>&nbsp</td></tr>
			<tr><th>お名前</th><td>'.$cur_namae.'</td><td>&nbsp</td></tr>
			<tr><th>状態</th><td>'.fnc_state($cur_state).'</td><td>←「メアド承認」状態であることを確認してください</td></tr>
			<tr><th>支払情報</th><td>'.$cur_orderid.'&nbsp;</td><td>←ブランクであることを確認してください</td></tr>
			<tr><th>設定ＵＲＬ</th><td colspan="2"><a href="'.$url.'" target="_blank">'.$url.'</td></tr>
			</table>
			&nbsp;<br/>
			&nbsp;<br/>
			<table border="1">
			<tr><th>メール送信</th><td><input type="text" size="30" value="'.$cur_email.'" id="edit_email">　
			<input type="hidden" id="edit_url" value="'.urlencode($url).'">
			<input type="button" value="送信" onclick="fncsendmail();">
			</td></tr>
			</table>

			<script>
			// 確認メール
			function fncsendmail()	{
				if (jQuery("#edit_email").val() == "")	{
					alert("メールアドレスが入力されていません。");
					return false;
				}
				if (confirm("支払方法設定ＵＲＬをメールでお送りします。よろしいですか？"))	{
					jQuery("#processing").show();
					jQuery.ajax({
						type: "POST",
						url: "'.$url_base.'data/zeus/payment_sendmail",
						data: "edit_email=" + jQuery("#edit_email").val() + "&edit_url=" + jQuery("#edit_url").val() ,
						success: function(msg){
							jQuery("#processing").hide();
							alert(msg);
						},
						error:function(){
							jQuery("#processing").hide();
							alert("通信エラーが発生しました。");
						}
					});
				}
			}
			</script>

		';
		break;

	case "payment_sendmail":
		// 支払方法設定ＵＲＬメール送信
		$email = fnc_getpost('edit_email');
		$url = urldecode(fnc_getpost('edit_url'));

		// 確認メールを送信
		$subject = "メンバー登録料のお支払方法に関するご連絡です";
		$mail  = '';
		$mail .= '日本ワーキングホリデー協会です。';
		$mail .= chr(10);
		$mail .= chr(10);
		$mail .= 'この度は、当協会のメンバーにご登録頂きましてありがとうございます。';
		$mail .= chr(10);
		$mail .= '恐れ入りますが、以下のＵＲＬより、メンバー登録料のお支払方法選択をお願い致します。';
		$mail .= chr(10);
		$mail .= chr(10);
		$mail .= $url;
		$mail .= chr(10);
		$mail .= chr(10);
		$mail .= '◆このメールに覚えが無い場合◆';
		$mail .= chr(10);
		$mail .= '当協会に登録されたメールアドレスに誤りがある可能性があります。';
		$mail .= chr(10);
		$mail .= 'お手数ですが、 info@jawhm.or.jp までご連絡頂ければ幸いです。';
		$mail .= chr(10);
		$mail .= '';
        //$from = mb_encode_mimeheader(mb_convert_encoding("日本ワーキングホリデー協会","JIS"))."<info@jawhm.or.jp>";
        $from = mb_encode_mimeheader(mb_convert_encoding("日本ワーキングホリデー協会","JIS"))."<j-doi@plate.co.jp>";
		mb_send_mail($email,$subject,$mail,"From:".$from);

		$msg = $email.'に確認メールを送信しました。';
		$body[] .= $msg;

		break;

	case "member":
		// メンバー登録料支払い

		$id = $param[3];

		try {
			$stt = $db->prepare('SELECT id, email, namae, tel, state, orderid, orderdate FROM memlist WHERE id = "'.$id.'"');
			$stt->execute();
			$idx = 0;
			while($row = $stt->fetch(PDO::FETCH_ASSOC)){
				$idx++;
				$cur_id = $row['id'];
				$cur_email = $row['email'];
				$cur_namae = $row['namae'];
				$cur_tel = $row['tel'];
				$cur_state = $row['state'];
				$cur_orderid = $row['orderid'];
				$cur_orderdate = $row['orderdate'];

			}
		} catch (PDOException $e) {
			die($e->getMessage());
		}


		$body_title[] .= 'メンバー登録料支払い';
		$body[] .= '
			メンバー登録料をカードで決済します。「クレジットカード決済ページへ」ボタンを押してください。<br/>
			&nbsp;<br/>
			<table border="1">
			<tr><th>会員番号</th><td>'.$cur_id.'</td><td>&nbsp</td></tr>
			<tr><th>お名前</th><td>'.$cur_namae.'</td><td>&nbsp</td></tr>
			<tr><th>状態</th><td>'.fnc_state($cur_state).'</td><td>←「メアド承認」状態であることを確認してください</td></tr>
			<tr><th>支払情報</th><td>'.$cur_orderid.'&nbsp;</td><td>←ブランクであることを確認してください</td></tr>
			</table>
			&nbsp;<br/>
			<form method="post" action="https://linkpt.cardservice.co.jp/cgi-bin/order.cgi?orders" enctype="x-www.form-encoded" target="_blank" onsubmit="window.close();">
				<input type="hidden" name="send" value="mail">
				<input type="hidden" name="clientip" value="2014000153">
				<input type="hidden" name="money" value="5000">
				<input type="hidden" name="custom" value="yes">
				<input type="hidden" name="usrtel" value="'.$cur_tel.'">
				<input type="hidden" name="usrmail" value="'.$cur_email.'">
				<input type="hidden" name="usrname" value="">
				<input type="hidden" name="sendid" value="'.$cur_id.'">
				<input type="hidden" name="sendpoint" value="manual">
				<input type="submit" class="button_submit" value="クレジットカード決済ページへ">
			</form>
		';
		break;

	case "conv":
		// メンバー登録料　コンビニ決済

		$id = $param[3];
		$new = @$param[4];

		try {
			if ($new == 'new')	{
				// 新しいシーケンス取得
				$stt = $db->prepare('SELECT seq FROM kessai_seq');
				$stt->execute();
				while($row = $stt->fetch(PDO::FETCH_ASSOC)){
					$cur_seq = $row['seq'];
				}
				$cur_num = intval($cur_seq) + 1;
				$stt = $db->prepare('UPDATE kessai_seq SET seq = '.$cur_num.' ');
				$stt->execute();
				// ＳＩＤ変更
				$dat_sid = $id.substr('000000'.strval($cur_num),-6);
				$stt = $db->prepare('UPDATE memlist SET sid = "'.$dat_sid.'" where id = "'.$id.'" ');
				$stt->execute();
			}

			$stt = $db->prepare('SELECT id, email, namae, tel, state, orderid, orderdate, sid, add1, add2, payment FROM memlist WHERE id = "'.$id.'"');
			$stt->execute();
			$idx = 0;
			while($row = $stt->fetch(PDO::FETCH_ASSOC)){
				$idx++;
				$cur_id = $row['id'];
				$cur_email = $row['email'];
				$cur_namae = $row['namae'];
				$cur_tel = $row['tel'];
				$cur_state = $row['state'];
				$cur_orderid = $row['orderid'];
				$cur_orderdate = $row['orderdate'];
				$cur_sid = $row['sid'];
				$cur_add1 = $row['add1'];
				$cur_add2 = $row['add2'];
				$cur_payment = $row['payment'];
			}
		} catch (PDOException $e) {
			die($e->getMessage());
		}

		$split_name	= mb_split("　", $cur_namae);
		$dat_name1	= $split_name[0];
		$dat_name2	= $split_name[1];


		$body_title[] .= 'メンバー登録料支払い';
		$body[] .= '
			メンバー登録料をコンビニで決済します。「コンビニ決済ページへ」ボタンを押してください。<br/>
			&nbsp;<br/>
			<table border="1">
			<tr><th>会員番号</th><td>'.$cur_id.'</td><td>&nbsp</td></tr>
			<tr><th>取引コード</th><td>'.$cur_sid.'</td><td><a href="./'.$cur_id.'/new">新しい取引コードを採番</a></td></tr>
			<tr><th>予定支払方法</th><td>'.$cur_payment.'</td><td>&nbsp</td></tr>
			<tr><th>お名前</th><td>'.$cur_namae.'</td><td>&nbsp</td></tr>
			<tr><th>状態</th><td>'.fnc_state($cur_state).'</td><td>←「メアド承認」状態であることを確認してください</td></tr>
			<tr><th>支払情報</th><td>'.$cur_orderid.'&nbsp;</td><td>←ブランクであることを確認してください</td></tr>
			</table>
			&nbsp;<br/>
			<form method="post" action="http://www.jawhm.or.jp/check.php" enctype="x-www.form-encoded" target="_blank" onsubmit="window.close();">
				<input type="hidden" name="ip" value="D363045858">
				<input type="hidden" name="sid" value="'.$cur_sid.'">
				<input type="hidden" name="fuka" value="'.$cur_id.'">
				<input type="hidden" name="name1" value="'.urlencode($dat_name1).'">
				<input type="hidden" name="name2" value="'.urlencode($dat_name2).'">
				<input type="hidden" name="tel" value="'.$cur_tel.'">
				<input type="hidden" name="adr1" value="'.urlencode($cur_add1).'">
				<input type="hidden" name="adr2" value="'.urlencode($cur_add2).'">
				<input type="hidden" name="mail" value="'.$cur_email.'">
				<input type="hidden" name="n1" value="'.urlencode("メンバー登録料").'>
				<input type="hidden" name="k1" value="5218">
				<input type="hidden" name="tax" value="238">
				<input type="submit" class="button_submit" value="コンビニ決済ページへ">
			</form>
		';
		break;

	case "convmanu":
		// 手動コンビニ決済

		try {
			// 新しいシーケンス取得
			$stt = $db->prepare('SELECT seq FROM kessai_seq');
			$stt->execute();
			while($row = $stt->fetch(PDO::FETCH_ASSOC)){
				$cur_seq = $row['seq'];
			}
			$cur_num = intval($cur_seq) + 1;
			$stt = $db->prepare('UPDATE kessai_seq SET seq = '.$cur_num.' ');
			$stt->execute();

			// ＳＩＤ作成
			$dat_sid = 'MANUAL'.substr('000000'.strval($cur_num),-6);

		} catch (PDOException $e) {
			die($e->getMessage());
		}

		$body_title[] .= 'コンビニ手動決済';
		$body[] .= '
<script>
function fncUchizei()	{
	var k1 = document.getElementById(\'k1\');
	var tax = document.getElementById(\'tax\');

	var moto = Number(k1.value);
	var keisan = Math.ceil(moto / 1.05);
	var gaku = moto - keisan;

	tax.value = gaku;

}
</script>
			コンビニの手動決済手配を行います。<br/>
			&nbsp;<br/>
			<form method="post" action="https://www.digitalcheck.jp/settle/settle3/bp3.dll" target="_blank" accept-charset="Shift_JIS" onsubmit="document.charset=\'SHIFT-JIS\';">
				<table border="1">
				<tr><th>決済番号</th><td><input type="text" name="SID" value="'.$dat_sid.'" readonly locked></td><td>変更しないでください</td></tr>
				<tr><th>お名前</th><td><input type="text" name="NAME1" value="" style="ime-mode:active;">&nbsp;様　　</td><td>支払時にコンビニ端末に表示されます</td></tr>
				<tr><th>電話番号<br/>（ハイフン不要）</th><td><input type="text" name="TEL" value="" style="ime-mode:inactive;">　*ハイフン入力禁止</td><td>ハイフン不要（不明な場合は0363045858）</td></tr>
				<tr><th>住所<br />（都道府県）</th><td><input type="text" name="ADR1" value="" style="ime-mode:active;"></td><td>都道府県のみ入力（不明な場合は東京都）</td></tr>
				<tr><th>商品名</th><td><input type="text" name="N1" value="日本ワーキングホリデー協会" size=50 style="ime-mode:active;"></td><td>２５文字以内で商品名を入力<br />例：　メンバー登録料<br/>　　　英会話コース料金　等</td></tr>
				<tr><th>支払額</th><td><input id="k1" type="text" name="K1" value="0" onchange="fncUchizei();" style="ime-mode:inactive;"><br /><br />内消費税額：<br /><input id="tax" type="text" name="TAX" value="0" readonly locked></td><td>税込価格を入力<br/>【手数料】<br/>3,000円未満　　186円<br/>10,000円未満　　218円<br/>30,000円未満　　270円<br/>100,000円未満　　323円</td></tr>
				</table>
				<input type="hidden" name="IP" value="D363045858">
				<input type="hidden" name="FUKA" value="MANUAL">
				<input type="hidden" name="NAME2" value="　">
				<input type="hidden" name="MAIL" value="info@jawhm.or.jp">
				<input type="hidden" name="STORE" value="99">
				&nbsp;<br/>
				　　　　　<input type="submit" class="button_submit" value="コンビニ決済予約">
			</form>
		';
		break;

	case "card":
		// 決済情報登録
		$body_title[] .= '決済情報登録';
		$body[] .= '
			この機能は、現在使用できません。<br/>
		';

		break;

	case "netcard":
		// 決済情報登録

		$edit_namae = fnc_getpost('namae');
		$edit_youto = fnc_getpost('youto');
		$edit_memo = fnc_getpost('memo');
		$edit_money = fnc_getpost('money');
		$edit_sendid = fnc_getpost('sendid');
		$edit_authcd = getRandomString(30);

		$sql  = 'INSERT INTO card (';
		$sql .= ' authcd, sendid, amount, insdate, namae, youto, memo ';
		$sql .= ') VALUES (';
		$sql .= ' :authcd, :sendid, :amount, :insdate, :namae, :youto, :memo ';
		$sql .= ')';
		$stt2 = $db->prepare($sql);
		$stt2->bindValue(':authcd'	, $edit_authcd);
		$stt2->bindValue(':sendid'	, $edit_sendid);
		$stt2->bindValue(':amount'	, $edit_money);
		$stt2->bindValue(':insdate'	, date('Y-m-d'));
		$stt2->bindValue(':namae'	, $edit_namae);
		$stt2->bindValue(':youto'	, $edit_youto);
		$stt2->bindValue(':memo'	, $edit_memo);
		$stt2->execute();

		$msg = '';
		$msg .= '
			<div style="padding:10px 10px 10px 10px; border: 1px dotted navy; margin: 10px 10px 10px 10px;">
				ネット決済用ＵＲＬは次の通りです。<br/>
				&nbsp;<br/>
				<a href="http://www.jawhm.or.jp/card/pay/'.$edit_authcd.'" target="_blank">http://www.jawhm.or.jp/card/pay/'.$edit_authcd.'</a><br/>
				&nbsp;<br/>
			</div>
		';

		$body[] .= $msg;

		break;

}


?>