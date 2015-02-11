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
		// メールテンプレート

		// 操作系ＪＳ
		$script .= '
			// 表示リクエスト
			function fnctempShow(keycd)	{
			jQuery("#processing").show();
				jQuery.ajax({
					type: "POST",
					url: "'.$url_base.'data/mailtemp/show",
					data: "keycd=" + keycd,
					success: function(msg){
						jQuery("#processing").hide();
						jQuery("#res_mailtemp_edit").html(msg);
						fncShow(\'div_mailtemp_edit\', 650, 600);
					},
					error:function(){
						jQuery("#processing").hide();
						alert("通信エラーが発生しました。");
					}
				});
			}

			// 入力チェック
			function fncPost(formname)	{
				document.getElementById("mailtempsubmit").value = "Wait";
				document.getElementById("mailtempsubmit").disabled = true;
				jQuery("#processing").show();
				jQuery.ajax({
					type: "POST",
					url: "'.$url_base.'data/mailtemp/edit",
					data: jQuery("#" + formname).serialize(),
					success: function(msg){
						jQuery("#processing").hide();
						res = eval(msg);
						alert(res[0].msg);
						if (res[0].result == \'OK\')	{
							jQuery.unblockUI();
						}
					},
					error:function(){
						jQuery("#processing").hide();
						alert("通信エラーが発生しました。");
					}
				});
			}
		';

		// 検索画面表示
		$body_title[] .= 'メールテンプレート設定';
		$body[] .= '
			設定するテンプレートを選択してください<br/>
			&nbsp;<br/>
			【セミナー関連】<br/>
			&nbsp;<br/>
			　　<input type=button class="button_save" value="　セミナー出席者へのサンキューメール" onclick="fnctempShow(\'auto_seminar_shusseki\');"><br/>
			&nbsp;<br/>
			　　<input type=button class="button_save" value="　セミナー欠席者へのご案内メール" onclick="fnctempShow(\'auto_seminar_kesseki\');"><br/>
			&nbsp;<br/>
			&nbsp;<br/>
			&nbsp;<br/>
			<div id="res_mailtemp_edit" style=""></div>
		';

		break;
	case "show":
		// メールテンプレート表示
		$cur_keycd = fnc_getpost('keycd');

		$title = '【メールテンプレート修正】';
		try {
			$stt = $db->prepare('SELECT text1, text2, text3, text4, text5 FROM mailtext WHERE keycd = "'.$cur_keycd.'"');
			$stt->execute();
			$idx = 0;
			while($row = $stt->fetch(PDO::FETCH_ASSOC)){
				$idx++;
				$cur_text1 = $row['text1'];
				$cur_text2 = $row['text2'];
				$cur_text3 = $row['text3'];
				$cur_text4 = $row['text4'];
				$cur_text5 = $row['text5'];
			}
		} catch (PDOException $e) {
			die($e->getMessage());
		}

		$msg = '
			<div id="div_mailtemp_edit" style="display:none; margin:10px 20px 10px 20px; font-size:10pt; cursor:default;">
				<div style="margin:0 0 10px 0; font-size:10pt; font-weight:bodl;">'.$title.'</dib>
				<form id="form_mailtemp_edit">
				<input type="hidden" name="edit_keycd" value="'.$cur_keycd.'">
				<table style="font-size:10pt;">
					<tr>
						<td class="label" width="120">用途</td>
						<td class="infield" width="500">'.field_text('edit_text1', 80, $cur_text1).'</td>
					</tr>
					<tr>
						<td class="label">タイトル</td>
						<td class="infield">'.field_text('edit_text2', 80, $cur_text2).'</td>
					</tr>
					<tr>
						<td class="label">メール本文</td>
						<td class="infield">
							<textarea name="edit_text3" cols="60" rows="10" style="font-size:10pt">'.$cur_text3.'</textarea>
						</td>
					</tr>
					<tr>
						<td class="label">署名</td>
						<td class="infield">
							<textarea name="edit_text4" cols="60" rows="2" style="font-size:10pt">'.$cur_text4.'</textarea>
						</td>
					</tr>
					<tr>
						<td class="label">備考</td>
						<td class="infield">
							<textarea name="edit_text5" cols="60" rows="2" style="font-size:10pt">'.$cur_text5.'</textarea>
						</td>
					</tr>
					<tr>
						<td colspan="2" style="text-align:right;">
							<input type=button class="button_cancel" value="やめる" onclick="fncHide();">&nbsp;&nbsp;
							<input type=button class="button_submit" value="登録" id="mailtempsubmit" onclick="fncPost(\'form_mailtemp_edit\');">
						</td>
					</tr>
				</table>
				</form>
			</div>
		';
		$body[] .= $msg;
		break;

	case "edit":
		// メールテンプレート修正

		$edit_keycd = fnc_getpost('edit_keycd');
		$edit_text1 = fnc_getpost('edit_text1');
		$edit_text2 = fnc_getpost('edit_text2');
		$edit_text3 = fnc_getpost('edit_text3');
		$edit_text4 = fnc_getpost('edit_text4');
		$edit_text5 = fnc_getpost('edit_text5');

		try {
			// 既存更新
			$sql  = 'UPDATE mailtext SET ';
			$sql .= '  text1 = :text1 ';
			$sql .= ', text2 = :text2 ';
			$sql .= ', text3 = :text3 ';
			$sql .= ', text4 = :text4 ';
			$sql .= ', text5 = :text5 ';
			$sql .= ' WHERE keycd = "'.$edit_keycd.'"';
			$stt = $db->prepare($sql);
			$stt->bindValue(':text1', $edit_text1);
			$stt->bindValue(':text2', $edit_text2);
			$stt->bindValue(':text3', $edit_text3);
			$stt->bindValue(':text4', $edit_text4);
			$stt->bindValue(':text5', $edit_text5);
			$stt->execute();
			$arr = array(
				array(
				"result" => "OK",
				"msg"  => "更新しました"
				)
			);
		} catch (PDOException $e) {
			$arr = array(
				array(
				"result" => "NG",
				"msg"  => $e->getMessage()
				)
			);
		}

		$msg = json_encode($arr);
		$body[] .= $msg;

		break;

}


?>