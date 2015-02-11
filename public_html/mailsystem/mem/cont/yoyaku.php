<?php

// 一般メニュー読み込み
require 'php/fnc_menu.php';


if (count($param) > 2) {
	$data_param = $param[2];
}else{
	$data_param = 'main';
}

//echo '<hr>yoyaku<br>';
//var_dump($param);
//echo '<br>';
//var_dump($data_param);

$para_seminarid = @$_GET['seminarid'];


switch ($data_param)	{
	case "main":
		// 予約管理

		// 予約操作系ＪＳ
		$script .= '
			// カレンダー表示
			InputCalendar.createOnLoaded(\'ser_hiduke\', {lang:\'ja\'});
			InputCalendar.createOnLoaded(\'ser_hiduketo\', {lang:\'ja\'});

			// 予約検索
			function fncSeryoyakuList()	{
				jQuery("#processing").show();
				jQuery.ajax({
					type: "POST",
					url: "'.$url_base.'data/yoyaku/yoyaku_ser",
					data: jQuery("#form_yoyaku_list").serialize(),
					success: function(msg){
						jQuery("#processing").hide();
						jQuery("#res_yoyaku_list").html(msg);
					},
					error:function(){
						jQuery("#processing").hide();
						alert("通信エラーが発生しました。");
					}
				});
			}

			function fncSeryoyakuCsv()	{
			jQuery("#processing").show();
				jQuery.ajax({
					type: "POST",
					url: "'.$url_base.'data/yoyaku/yoyaku_csv",
					data: jQuery("#form_yoyaku_list").serialize(),
					success: function(msg){
						jQuery("#processing").hide();
						res = eval(msg);
						if (res[0].result == \'OK\')	{
							if (confirm(res[0].msg + "出力しますか？"))	{
								window.open(\''.$url_base.'csv/yoyaku/yoyaku_csv/?type=out&\' + jQuery("#form_yoyaku_list").serialize(), \'_blank\', \'width=200,height=200\');
								return false;
							}
						}else{
							alert(res[0].msg);
						}
					},
					error:function(){
						jQuery("#processing").hide();
						alert("通信エラーが発生しました。");
					}
				});
			}

			// 予約表示リクエスト
			function fncyoyakuShow(id)	{
				jQuery("#processing").show();
				jQuery.ajax({
					type: "POST",
					url: "'.$url_base.'data/yoyaku/yoyaku_show",
					data: "id=" + id,
					success: function(msg){
						jQuery("#processing").hide();
						jQuery("#res_yoyaku_edit").html(msg);
						fncShow(\'div_yoyaku_edit\', 650, 450);
					},
					error:function(){
						jQuery("#processing").hide();
						alert("通信エラーが発生しました。");
					}
				});
			}

			// 予約入力チェック
			function fncyoyakuPost(formname)	{
				// 入力チェック
				var objform = document.getElementById(formname);
				var obj = objform.getElementsByTagName(\'input\');
				for (idx=0; idx<obj.length; idx++)	{
					if (obj[idx].getAttribute(\'required\') == \'yes\')	{
						if (obj[idx].value == \'\')	{
							alert("入力してください");
							obj[idx].focus();
							return false;
						}
					}
				}
				document.getElementById("yoyakusubmit").value = "Wait";
				document.getElementById("yoyakusubmit").disabled = true;
				jQuery("#processing").show();
				jQuery.ajax({
					type: "POST",
					url: "'.$url_base.'data/yoyaku/yoyaku_edit",
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

			// 確認メール
			function fncsendmail(id)	{
				if (confirm("確認メールをお送りします。よろしいですか？\nなお、このメールは登録済みメールアドレスに送信されます。"))	{
					jQuery("#processing").show();
					jQuery.ajax({
						type: "POST",
						url: "'.$url_base.'data/yoyaku/yoyaku_sendmail",
						data: "id=" + id,
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

			// 詳細表示
			function fncshowdesc(id, div)	{
				jQuery("#processing").show();
				jQuery.ajax({
					type: "POST",
					url: "'.$url_base.'data/yoyaku/yoyaku_showdesc",
					data: "id=" + id,
					success: function(msg){
						jQuery("#processing").hide();
						jQuery("#" + div).html(msg);
					},
					error:function(){
						jQuery("#processing").hide();
						alert("通信エラーが発生しました。");
					}
				});
			}

			// キャンセル
			function fnccancel(id)	{
				if (confirm("この予約をキャンセルします。よろしいですか？"))	{
					jQuery("#processing").show();
					jQuery.ajax({
						type: "POST",
						url: "'.$url_base.'data/yoyaku/yoyaku_cancel",
						data: "id=" + id,
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
			}

			// 繰上げ参加
			function fnckuriage(id)	{
				if (confirm("このCXL待ち予約を繰上て仮予約状態に変更します。よろしいですか？"))	{
					jQuery("#processing").show();
					jQuery.ajax({
						type: "POST",
						url: "'.$url_base.'data/yoyaku/yoyaku_kuriage",
						data: "id=" + id,
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
			}

			// 予約確定
			function fnchonyoyaku(id)	{
				if (confirm("この仮予約を確定します。よろしいですか？"))	{
					jQuery("#processing").show();
					jQuery.ajax({
						type: "POST",
						url: "'.$url_base.'data/yoyaku/yoyaku_kakutei",
						data: "id=" + id,
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
			}

			// 参加登録
			function fncshusseki(id)	{
				if (confirm("参加登録します。よろしいですか？"))	{
					jQuery("#processing").show();
					jQuery.ajax({
						type: "POST",
						url: "'.$url_base.'data/yoyaku/yoyaku_shusseki",
						data: "id=" + id,
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
			}

			// 一括参加登録
			function fncikkatushusseki()	{
				var chk = jQuery( "input:checked" ).map( function() { return jQuery(this).attr("ap"); }).get().join(",");
				if (chk == \'\')	{
					alert("参加登録の対象を選択してください。");
				}else{
					jQuery("#processing").show();
					jQuery.ajax({
						type: "POST",
						url: "'.$url_base.'data/yoyaku/ikkatu_shusseki",
						data: "id=" + chk,
						success: function(msg){
							jQuery("#processing").hide();
							jQuery("#res_yoyaku_edit").html(msg);
							fncShow(\'div_card_edit\', 420, 600);
						},
						error:function(){
							jQuery("#processing").hide();
							alert("通信エラーが発生しました。");
						}
					});
				}
			}

			// 発送手配入力チェック
			function fncikkatushussekipost(formname)	{
				if (!confirm(\'一括参加登録を実行します。よろしいですか？\'))	{
					return false;
				}
				jQuery("#processing").show();
				jQuery.ajax({
					type: "POST",
					url: "'.$url_base.'data/yoyaku/ikkatu_shusseki_go",
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

		$nextscript = '';
		if ($para_seminarid <> '')	{
			$nextscript .= '<script>
//				document.getElementById(\'ser_p4\').click();
				document.getElementById(\'ser_seminarid\').value = \''.$para_seminarid.'\';
				document.getElementById(\'seryoyakubtn\').click();
				</script>
			';
		}

		// 検索画面表示
		$body_title[] .= '予約検索';
		$body[] .= '
			<form id="form_yoyaku_list">
				<table>
					<tr>
						<td style="text-align:right;">予約日</td>
						<td colspan="3">
							<input id="ser_hiduke" name="ser_hiduke" size="16" type="text" value=""/>
							　～　
							<input id="ser_hiduketo" name="ser_hiduketo" size="16" type="text" />
						</td>
					</tr>
					<tr>
						<td style="text-align:right;">キーワード</td>
						<td>
							'.field_text('ser_keyword1', 20, '').'　and　
							'.field_text('ser_keyword2', 20, '').'　and　
							'.field_text('ser_keyword3', 20, '').'
						</td>
					</tr>
					<tr>
						<td style="text-align:right;">状態</td>
						<td colspan="3">
							<input type=checkbox name="ser_p1" value="0" checked>仮予約　
							<input type=checkbox name="ser_p2" value="1" checked>予約　
							<input type=checkbox name="ser_p3" value="6">キャンセル　
							<input type=checkbox name="ser_p5" value="2">参加　
							<input type=checkbox name="ser_p6" value="7">不参加　
							<input type=checkbox name="ser_p4" id="ser_p4" value="A">全て
						</td>
					</tr>
					<tr>
						<td style="text-align:right;">セミナー番号</td>
						<td>
							<input type="text" size="4" id="ser_seminarid" name="ser_seminarid" value="">
						</td>
					</tr>
					<tr>
						<td>
							<input class="button_csv" type="button" value="CSV" id="seryoyakucsv" onclick="fncSeryoyakuCsv();"">
						</td>
						<td>
							<input class="button" type="button" value="一括参加登録" id="ikkatushusseki" onclick="fncikkatushusseki();"">
						</td>



						<td colspan="6" style="text-align:right;">
							<input class="button_cancel" type="reset" value="clear" onclick="jQuery(\'#res_yoyaku_list\').html(\'\');jQuery(\'#ser_seminarid\').val(\'\');">&nbsp;&nbsp;
							<input class="button_submit" type="button" value="Search" id="seryoyakubtn" onclick="fncSeryoyakuList();"">
						</td>
					</tr>
				</table>
			</form>
			<div id="res_yoyaku_list" style=""></div>
			<div id="res_yoyaku_edit" style=""></div>
			'.$nextscript;

		// 新規登録表示
//		$body_title[] .= '新規予約';
//		$body[] .= '
//			<input type=button class="button_save" value="　新しい予約を登録する" onclick="fncyoyakuShow(\'\');">
//			<div id="res_yoyaku_edit" style=""></div>
//		';

		break;

	case "yoyaku_show":
		// 予約編集（新規）
		$id = fnc_getpost('id');
		$cur_id = $id;
		$cur_seminarid = '';
		$cur_seminarname = '';
		$cur_namae = '';
		$cur_furigana = '';
		$cur_tel = '';
		$cur_email = '';
		$cur_kyomi = '';
		$cur_jiki = '';
		$cur_sonota = '';
		$cur_ninzu = '1';
		$cur_stat = '0';
		$cur_wait = '0';
		$cur_insdate = '';
		$cur_upddate = '';
		$cur_customid = '';
		$cur_mailstat = '';

		if ($id == '')	{
			$title = '【新しい予約を登録する】';
			$cur_id = '';
			$cur_seminarid = fnc_getpost('seminarid');
			try {
				$stt = $db->prepare('SELECT id, starttime, k_title1, pax, booking, waitting FROM event_list WHERE id = "'.$cur_seminarid.'"');
				$stt->execute();
				$idx = 0;
				while($row = $stt->fetch(PDO::FETCH_ASSOC)){
					$idx++;
					$cur_seminarname = $row['k_title1'];
					$cur_starttime = $row['starttime'];
					$cur_pax = $row['pax'];
					$cur_booking = $row['booking'];
					$cur_waitting = $row['waitting'];
				}
			} catch (PDOException $e) {
				die($e->getMessage());
			}
		}else{
			$title = '【予約情報修正】';
			try {
				$stt = $db->prepare('SELECT id, seminarid, seminarname, namae, furigana, tel, email, kyomi, jiki, sonota, ninzu, stat, wait, mailstat, customid, insdate, upddate FROM entrylist WHERE id = "'.$cur_id.'"');
				$stt->execute();
				$idx = 0;
				while($row = $stt->fetch(PDO::FETCH_ASSOC)){
					$idx++;
					$cur_id = $row['id'];
					$cur_seminarid = $row['seminarid'];
					$cur_seminarname = $row['seminarname'];
					$cur_namae = $row['namae'];
					$cur_furigana = $row['furigana'];
					$cur_tel = $row['tel'];
					$cur_email = $row['email'];
					$cur_kyomi = $row['kyomi'];
					$cur_jiki = $row['jiki'];
					$cur_ninzu = $row['ninzu'];
					$cur_sonota = $row['sonota'];
					$cur_stat = $row['stat'];
					$cur_wait = $row['wait'];
					$cur_customid = $row['customid'];
					$cur_insdate = $row['insdate'];
					$cur_upddate = $row['upddate'];
					$cur_mailstat = $row['mailstat'];
				}
				$stt = $db->prepare('SELECT id, starttime, k_title1, pax, booking, waitting FROM event_list WHERE id = "'.$cur_seminarid.'"');
				$stt->execute();
				$idx = 0;
				while($row = $stt->fetch(PDO::FETCH_ASSOC)){
					$idx++;
					$cur_seminarname = $row['k_title1'];
					$cur_starttime = $row['starttime'];
					$cur_pax = $row['pax'];
					$cur_booking = $row['booking'];
					$cur_waitting = $row['waitting'];
				}
			} catch (PDOException $e) {
				die($e->getMessage());
			}
		}

		$cxlbutton = '';
		$stat = '';
		if ($cur_wait == '1' )	{
			$stat .= 'CXL待ち';
		}
		switch($cur_stat)	{
			case '0':
				if ($cur_id == '')	{
					$stat .= '新規予約';
				}else{
					$stat .= '仮予約 (予約:'.$cur_insdate.')';
					$cxlbutton .= '<input type="button" value="予約キャンセル" onclick="fnccancel(\''.$cur_id.'\');">';
					if ($cur_wait == '1' )	{
						$cxlbutton .= '<input type="button" value="繰上参加" onclick="fnckuriage(\''.$cur_id.'\');">';
					}else{
						$cxlbutton .= '<input type="button" value="予約確定" onclick="fnchonyoyaku(\''.$cur_id.'\');">';
					}
					$cxlbutton .= '　<input type="button" value="参加登録" onclick="fncshusseki(\''.$cur_id.'\');">';
				}
				break;
			case '1':
				$stat .= '予約';
				$cxlbutton .= '<input type="button" value="予約キャンセル" onclick="fnccancel(\''.$cur_id.'\');">';
				$cxlbutton .= '　<input type="button" value="参加登録" onclick="fncshusseki(\''.$cur_id.'\');">';
				break;
			case '2':
				$stat .= '参加';
				break;
			case '3':
				$stat .= '携帯仮 (予約:'.$cur_insdate.')';
				$cxlbutton .= '<input type="button" value="予約キャンセル" onclick="fnccancel(\''.$cur_id.'\');">';
				$cxlbutton .= '　<input type="button" value="参加登録" onclick="fncshusseki(\''.$cur_id.'\');">';
				break;
			case '5':
				$stat .= '自動キャンセル';
				break;
			case '6':
				$stat .= 'キャンセル';
				break;
			case '7':
				$stat .= '不参加';
				break;
		}

		$seminarpax  = '<br/>';
		if ($cur_booking >= $cur_pax)	{
			$seminarpax .= '<span style="background-color:red; color:white; font-weight:bold;">　満席　</span>　　';
		}
		$seminarpax .= '予約 : '.$cur_booking.'　　CXL待ち : '.$cur_waitting.'　　定員 : '.$cur_pax;

		$mailbutton = '';
		if ($cur_id <> '')	{
			$mailbutton = '<input type="button" value="メール送信" onclick="fncsendmail(\''.$cur_id.'\');">';
			if ($cur_mailstat == '9')	{
				$mailbutton .= '<span style="background:red; font-size:9pt; margin-left:8px; padding:2px 5px 2px 5px; color:white;">フォローメール不要</span>';
			}else{
				$mailbutton .= '<br/><input type="checkbox" name="edit_mailstat">フォローメール不要';
			}
		}else{
			$mailbutton .= '　<input type="checkbox" name="edit_amail" checked>案内メールを送信する';
		}
		$msg = '
			<div id="div_yoyaku_edit" style="display:none; margin:10px 20px 10px 20px; font-size:10pt; cursor:default;overflow: auto;">
				<div style="margin:0 0 10px 0; font-size:12pt; font-weight:bold;">'.$title.'</dib>
				<form id="form_yoyaku_edit">
				<table>
					<tr>
						<td class="label" width="120">セミナー</td>
						<td class="infield" width="500">
							日時 : '.$cur_starttime.'<br/>
							名称 : <input type="text" name="edit_seminarname" value="'.$cur_seminarname.'" size="60" readonly>
							&nbsp;<span id="seminarpax">'.$seminarpax.'</span>
							<input type="hidden" name="edit_id" value="'.$cur_id.'">
							<input type="hidden" name="edit_seminarid" value="'.$cur_seminarid.'">
							<input type="hidden" name="old_stat" value="'.$cur_stat.'">
							<input type="hidden" name="old_wait" value="'.$cur_wait.'">
							<input type="hidden" name="old_ninzu" value="'.$cur_ninzu.'">
						</td>
					</tr>
					<tr>
						<td class="label">お名前</td>
						<td class="infield">'.field_required('edit_namae', 25, $cur_namae).'</td>
					</tr>
					<tr>
						<td class="label">フリガナ</td>
						<td class="infield">'.field_text('edit_furigana', 25, $cur_furigana).'</td>
					</tr>
					<tr>
						<td class="label">電話番号</td>
						<td class="infield">'.field_text('edit_tel', 30, $cur_tel).'</td>
					</tr>
					<tr>
						<td class="label">メール</td>
						<td class="infield">'.field_text('edit_email', 50, $cur_email).$mailbutton.'</td>
					</tr>
					<tr>
						<td class="label">興味国</td>
						<td class="infield">'.field_text('edit_kyomi', 80, $cur_kyomi).'</td>
					</tr>
					<tr>
						<td class="label">出発時期</td>
						<td class="infield">'.field_text('edit_jiki', 80, $cur_jiki).'</td>
					</tr>
					<tr>
						<td class="label">その他</td>
						<td class="infield">'.field_text('edit_sonota', 80, $cur_sonota).'</td>
					</tr>
					<tr>
						<td class="label">予約人数</td>
						<td class="infield"><input type="text" name="edit_ninzu" size="3" value="'.$cur_ninzu.'" ';
				if ($cur_id <> '')	{ $msg .= ' readonly ';	}
				$msg .= '>	</td>
					</tr>
					<tr>
						<td class="label">状態</td>
						<td class="infield">'.$stat.'　　'.$cxlbutton.'　　CRM_ID : '.$cur_customid.'
						</td>
					</tr>
					<tr>
						<td class="label">予約日時</td>
						<td class="infield"> '.$cur_insdate.' </td>
					</tr>
					<tr>
						<td class="label">最終変更日時</td>
						<td class="infield"> '.$cur_upddate.' </td>
					</tr>
					<tr>
						<td colspan="2" style="text-align:right;">
							<input type=button class="button_cancel" value="やめる" onclick="fncHide();">&nbsp;&nbsp;
							<input type=button class="button_submit" value="登録" id="yoyakusubmit" onclick="fncyoyakuPost(\'form_yoyaku_edit\');">
						</td>
					</tr>
				</table>
				</form>
			</div>
		';
		$body[] .= $msg;
		break;

	case "yoyaku_edit":
		// 予約情報修正

		$edit_id = fnc_getpost('edit_id');
		$edit_seminarid = fnc_getpost('edit_seminarid');
		$edit_seminarname = fnc_getpost('edit_seminarname');
		$edit_namae = fnc_getpost('edit_namae');
		$edit_furigana = fnc_getpost('edit_furigana');
		$edit_tel = fnc_getpost('edit_tel');
		$edit_email = fnc_getpost('edit_email');
		$edit_amail = fnc_getpost('edit_amail');
		$edit_kyomi = fnc_getpost('edit_kyomi');
		$edit_jiki = fnc_getpost('edit_jiki');
		$edit_sonota = fnc_getpost('edit_sonota');
		$edit_ninzu = fnc_getpost('edit_ninzu');
		$edit_mailstat = fnc_getpost('edit_mailstat');

		$old_ninzu = fnc_getpost('old_ninzu');
		$old_stat = fnc_getpost('old_stat');
		$old_wait = fnc_getpost('old_wait');

		try {
			if ($edit_id == '')	{
				// 予約番号採番
				$stt = $db->prepare('SELECT max(id) as maxid FROM entrylist');
				$stt->execute();
				$idx = 0;
				$yoyakuno = 0;
				while($row = $stt->fetch(PDO::FETCH_ASSOC)){
					$idx++;
					$yoyakuno = $row['maxid'];
				}
				$yoyakuno++;

				// ＣＲＭに転送
				$data = array(
						 'pwd' => '303pittST'
						,'act' => 'yoyaku'
						,'edit_namae' => $edit_namae
						,'edit_furigana' => $edit_furigana
						,'edit_tel' => $edit_tel
						,'edit_email' => $edit_email
						,'edit_seminarid' => $edit_seminarid
						,'edit_seminarname' => $edit_seminarname
					);

				$url = 'https://toratoracrm.com/crm/';
				$val = wbsRequest($url, $data);
				$ret = json_decode($val, true);

				$customid = '';
				if ($ret['result'] == 'OK')	{
					// OK
					$customid = $ret['customid'];
				}

				// 新規登録
				$sql  = 'INSERT INTO entrylist (';
				$sql .= ' id, seminarid, seminarname, namae, furigana, tel, email, kyomi, jiki, sonota, ninzu, stat, wait, customid, insdate, upddate ';
				$sql .= ') VALUES (';
				$sql .= ' :id, :seminarid, :seminarname, :namae, :furigana, :tel, :email, :kyomi, :jiki, :sonota, :ninzu, :stat, :wait, :customid, :insdate, :upddate ';
				$sql .= ')';
				$stt2 = $db->prepare($sql);
				$stt2->bindValue(':id'			, $yoyakuno);
				$stt2->bindValue(':seminarid'	, $edit_seminarid);
				$stt2->bindValue(':seminarname'	, $edit_seminarname);
				$stt2->bindValue(':namae'		, $edit_namae);
				$stt2->bindValue(':furigana'	, $edit_furigana);
				$stt2->bindValue(':tel'			, $edit_tel);
				$stt2->bindValue(':email'		, $edit_email);
				$stt2->bindValue(':kyomi'		, $edit_kyomi);
				$stt2->bindValue(':jiki'		, $edit_jiki);
				$stt2->bindValue(':sonota'		, $edit_sonota);
				$stt2->bindValue(':ninzu'		, $edit_ninzu);
				$stt2->bindValue(':stat'		, '1');
				$stt2->bindValue(':wait'		, '0');
				$stt2->bindValue(':customid'	, $customid);
				$stt2->bindValue(':insdate'		, date('Y/m/d H:i:s'));
				$stt2->bindValue(':upddate'		, date('Y/m/d H:i:s'));
				$stt2->execute();

				// セミナーマスタ更新
				$sql = 'UPDATE event_list SET booking = booking + '.$edit_ninzu.' WHERE id = '.$edit_seminarid;
				$stt = $db->prepare($sql);
				$stt->execute();

				$stt = $db->prepare('SELECT id, place, hiduke, year(hiduke) as y, month(hiduke) as m, day(hiduke) as d, date_format(hiduke,\'%w\') as yobi, date_format(starttime,\'%k:%i\') as sttime, k_title1, pax, booking, waitting, mailinfo FROM event_list WHERE id = "'.$edit_seminarid.'" ');
				$stt->execute();
				$idx = 0;
				$cur_id = '';
				while($row = $stt->fetch(PDO::FETCH_ASSOC)){
					$idx++;
					$cur_id = $row['id'];
					$cur_place = $row['place'];
					$cur_hiduke = $row['hiduke'];
					$cur_y = $row['y'];
					$cur_m = $row['m'];
					$cur_d = $row['d'];
					$cur_yobi = $row['yobi'];
					$cur_sttime = $row['sttime'];
					$cur_title1 = $row['k_title1'];
					$cur_pax = $row['pax'];
					$cur_booking = $row['booking'];
					$cur_waitting = $row['waitting'];
					$cur_mailinfo = $row['mailinfo'];
				}
				$youbi = Array("日","月","火","水","木","金","土");

				// メール送信
				if ($edit_email <> '' && $edit_amail == 'on')	{
					$subject = "イベント（セミナー）のご案内";
					$mail  = '';
					$mail .= '日本ワーキングホリデー協会です。';
					$mail .= chr(10);
					$mail .= 'イベント（セミナー）のご予約状態をご案内する為、このメールをお送りしております。';
					$mail .= chr(10);

					$mail .= chr(10);
					$mail .= '---------------';
					$mail .= chr(10);
					switch ($cur_place)	{
						case 'tokyo':
							$mail .='　東京会場';
							$mail .= chr(10);
							$mail .='　http://www.jawhm.or.jp/event/map?p=tokyo';
							$mail .= chr(10);
							break;
						case 'osaka':
							$mail .='　大阪会場';
							$mail .= chr(10);
							$mail .='　http://www.jawhm.or.jp/event/map?p=osaka';
							$mail .= chr(10);
							break;
						case 'nagoya':
							$mail .='　名古屋会場';
							$mail .= chr(10);
							$mail .='　http://www.jawhm.or.jp/event/map?p=nagoya';
							$mail .= chr(10);
							break;
						case 'fukuoka':
							$mail .='　福岡会場';
							$mail .= chr(10);
							$mail .='　http://www.jawhm.or.jp/event/map?p=fukuoka';
							$mail .= chr(10);
							break;
						case 'sendai':
							$mail .='　仙台会場';
							$mail .= chr(10);
							break;
						case 'okinawa':
							$mail .='　沖縄会場';
							$mail .= chr(10);
							$mail .='　http://www.jawhm.or.jp/event/map?p=okinawa';
							$mail .= chr(10);
							break;
					}
					$mail .= '　'.$cur_y.'年 '.$cur_m.'月 '.$cur_d.'日 ('.$youbi[$cur_yobi].'曜日)   '.$cur_sttime.' 開始';
					$mail .= chr(10);
					$mail .= '　「'.$cur_title1.'」';
					$mail .= chr(10);
					$mail .= '---------------';
					$mail .= chr(10);
					$mail .= $cur_mailinfo;
					$mail .= chr(10);
					$mail .= chr(10);
					$mail .= '現在の予約状態を確認する場合は、以下のURLを表示してください。';
					$mail .= chr(10);
					$mail .= 'http://www.jawhm.or.jp/yoyaku/disp/'.$yoyakuno.'/'.md5($edit_email);
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
					mb_send_mail($edit_email,$subject,$mail,"From:".$from);
					$arr = array(
						array(
						"result" => "OK",
						"msg"  => "登録しました。なお、案内メールをお送りしています。"
						)
					);
				}else{
					$arr = array(
						array(
						"result" => "OK",
						"msg"  => "登録しました"
						)
					);
				}
			}else{
				// 既存更新
				$sql  = 'UPDATE entrylist SET ';
				$sql .= '  namae = "'.$edit_namae.'"';
				$sql .= ', furigana = "'.$edit_furigana.'"';
				$sql .= ', tel = "'.$edit_tel.'"';
				$sql .= ', email = "'.$edit_email.'"';
				$sql .= ', kyomi = "'.$edit_kyomi.'"';
				$sql .= ', jiki = "'.$edit_jiki.'"';
				$sql .= ', sonota = "'.$edit_sonota.'"';
				$sql .= ', ninzu = "'.$edit_ninzu.'"';
				if ($edit_mailstat == 'on')	{
					$sql .= ', mailstat = "9"';
				}
				$sql .= ' WHERE id = "'.$edit_id.'"';
				$stt = $db->prepare($sql);
				$stt->execute();
				$arr = array(
					array(
					"result" => "OK",
					"msg"  => "更新しました"
					)
				);
			}
		} catch (PDOException $e) {
			$arr = array(
				array(
				"result" => "NG",
				"msg"  => $e->getMessage()
				)
			);
		}

		// カレンダー変更
		GC_Edit($edit_seminarid);

		$msg = json_encode($arr);
		$body[] .= $msg;

		break;

	case "yoyaku_ser":
		// 予約検索

		$ser_hiduke = fnc_getpost('ser_hiduke');
		$ser_hiduketo = fnc_getpost('ser_hiduketo');
		$ser_keyword1 = fnc_getpost('ser_keyword1');
		$ser_keyword2 = fnc_getpost('ser_keyword2');
		$ser_keyword3 = fnc_getpost('ser_keyword3');
		$ser_p1 = fnc_getpost('ser_p1');
		$ser_p2 = fnc_getpost('ser_p2');
		$ser_p3 = fnc_getpost('ser_p3');
		$ser_p4 = fnc_getpost('ser_p4');
		$ser_p5 = fnc_getpost('ser_p5');
		$ser_p6 = fnc_getpost('ser_p6');
		$ser_seminarid = fnc_getpost('ser_seminarid');

		$body_title[] .= '予約検索結果';
		$msg = '';
		$cond = ' 1=1 ';
		$cond_msg = '[検索条件] ';

		$cond .= ' and ( 1=0 ';
		if ($ser_p1 <> '')	{	$cond .= ' or stat = "0" or stat = "3" ';	}		// 仮予約
		if ($ser_p2 <> '')	{	$cond .= ' or stat = "1" ';					}		// 予約
		if ($ser_p3 <> '')	{	$cond .= ' or stat = "5" or stat = "6" '; 	}		// キャンセル
		if ($ser_p4 <> '')	{	$cond .= ' or stat <> "-1" ';				}		// 全て
		if ($ser_p5 <> '')	{	$cond .= ' or stat = "2" ';					}		// 参加
		if ($ser_p6 <> '')	{	$cond .= ' or stat = "7" ';					}		// 不参加
		$cond .= ' ) ';

		if ($ser_keyword1 <> '')	{
			$cond .= ' and ( ';
			$cond .= ' seminarname like "%'.$ser_keyword1.'%" or ';
			$cond .= ' namae like "%'.$ser_keyword1.'%" or ';
			$cond .= ' furigana like "%'.$ser_keyword1.'%" or ';
			$cond .= ' tel like "%'.$ser_keyword1.'%" or ';
			$cond .= ' email like "%'.$ser_keyword1.'%" ) ';
		}
		if ($ser_keyword2 <> '')	{
			$cond .= ' and ( ';
			$cond .= ' seminarname like "%'.$ser_keyword2.'%" or ';
			$cond .= ' namae like "%'.$ser_keyword2.'%" or ';
			$cond .= ' furigana like "%'.$ser_keyword2.'%" or ';
			$cond .= ' tel like "%'.$ser_keyword2.'%" or ';
			$cond .= ' email like "%'.$ser_keyword2.'%" ) ';
		}
		if ($ser_keyword3 <> '')	{
			$cond .= ' and ( ';
			$cond .= ' seminarname like "%'.$ser_keyword3.'%" or ';
			$cond .= ' namae like "%'.$ser_keyword3.'%" or ';
			$cond .= ' furigana like "%'.$ser_keyword3.'%" or ';
			$cond .= ' tel like "%'.$ser_keyword3.'%" or ';
			$cond .= ' email like "%'.$ser_keyword3.'%" ) ';
		}
		if ($ser_seminarid <> '')	{
			$cond .= ' and seminarid = '.$ser_seminarid;
		}
		if ($ser_hiduke <> '')	{
			$cond .= ' and entrylist.insdate >= "'.$ser_hiduke.' 00:00:00"';
		}
		if ($ser_hiduketo <> '')	{
			$cond .= ' and entrylist.insdate <= "'.$ser_hiduketo.' 23:59:59"';
		}

		$msg .= '<table class="listdata">';
		$msg .= '<tr>';
		if ($ser_seminarid <> '')	{
			$msg .= '<th></th>';
		}
		$msg .= '<th>編集</th>';
		$msg .= '<th width="80">状態</th>';
		$msg .= '<th width="">お名前</th>';
		$msg .= '<th width="">セミナー</th>';
		$msg .= '</tr>';

		$ini = parse_ini_file('../../../bin/pdo_mail_list.ini', FALSE);

		try {
			$stt = $db->prepare('SELECT entrylist.id, seminarid, seminarname, namae, furigana, tel, email, stat, wait, event_list.hiduke, date_format(starttime,\'%H:%i\') as sttime, event_list.place FROM entrylist, event_list WHERE entrylist.seminarid = event_list.id and '.$cond.' ORDER BY seminarid, id, furigana');
			$stt->execute();
			$idx = 0;
			while($row = $stt->fetch(PDO::FETCH_ASSOC)){
				$idx++;
				$cur_id = $row['id'];
				$cur_seminarid = $row['seminarid'];
				$cur_seminarname = $row['seminarname'];
				$cur_namae = $row['namae'];
				$cur_furigana = $row['furigana'];
				$cur_tel = $row['tel'];
				$cur_email = $row['email'];
				$cur_stat = $row['stat'];
				$cur_wait = $row['wait'];
				$cur_place = $row['place'];
				$cur_hiduke = $row['hiduke'];
				$cur_sttime = $row['sttime'];

				if ($idx % 2 == 0)	{
					$msg .= '<tr>';
				}else{
					$msg .= '<tr class="odd">';
				}
				if ($ser_seminarid <> '')	{
					$msg .= '<td><input type="checkbox" id="check_'.$cur_id.'" ap="'.$cur_id.'" class="selchk" onclick=""></td>';
				}
				$msg .= '<td><input type=button class="button_save" value=" 修正" onclick="fncyoyakuShow(\''.$cur_id.'\');"></td>';
				$msg .= '<td>';
				switch ($cur_stat)	{
					case '0':
						$msg .= '仮予約';
						break;
					case '1':
						$msg .= '予約';
						break;
					case '2':
						$msg .= '参加（終了）';
						break;
					case '3':
						$msg .= '携帯仮予約';
						break;
					case '5':
						$msg .= '自動キャンセル';
						break;
					case '6':
						$msg .= 'キャンセル';
						break;
					case '7':
						$msg .= '不参加（終了）';
						break;
				}
				if ($cur_wait == '1')	{
					$msg .= '<br/>(CXL待ち)';
				}
				$msg .= '</td>';
				$msg .= '<td><a id="list'.$cur_id.'" href="#'.$cur_id.'" onclick="fncshowdesc(\''.$cur_id.'\',\'div_'.$cur_id.'\');">'.$cur_namae.'('.$cur_furigana.')</a><div id="div_'.$cur_id.'"></div></td>';
				$msg .= '<td>'.$cur_hiduke.' '.$cur_sttime.'<br/>'.$cur_seminarname.'</td>';
				$msg .= '</tr>';
			}
		} catch (PDOException $e) {
			die($e->getMessage());
		}
		$msg .= '</table>';
		$body[] .= '[該当件数] '.$idx.'件'.$msg;

		break;

	case "yoyaku_csv":
		// 予約ＣＳＶ出力

		$type = fnc_getpost('type');

		$ser_hiduke = fnc_getpost('ser_hiduke');
		$ser_hiduketo = fnc_getpost('ser_hiduketo');
		$ser_keyword1 = fnc_getpost('ser_keyword1');
		$ser_keyword2 = fnc_getpost('ser_keyword2');
		$ser_keyword3 = fnc_getpost('ser_keyword3');
		$ser_p1 = fnc_getpost('ser_p1');
		$ser_p2 = fnc_getpost('ser_p2');
		$ser_p3 = fnc_getpost('ser_p3');
		$ser_p4 = fnc_getpost('ser_p4');
		$ser_p5 = fnc_getpost('ser_p5');
		$ser_p6 = fnc_getpost('ser_p6');
		$ser_seminarid = fnc_getpost('ser_seminarid');

		$msg = '';
		$cond = ' 1=1 ';

		$cond .= ' and ( 1=0 ';
		if ($ser_p1 <> '')	{	$cond .= ' or stat = "0" or stat = "3" ';	}		// 仮予約
		if ($ser_p2 <> '')	{	$cond .= ' or stat = "1" ';					}		// 予約
		if ($ser_p3 <> '')	{	$cond .= ' or stat = "5" or stat = "6" '; 	}		// キャンセル
		if ($ser_p4 <> '')	{	$cond .= ' or stat <> "-1" ';				}		// 全て
		if ($ser_p5 <> '')	{	$cond .= ' or stat = "2" ';					}		// 参加
		if ($ser_p6 <> '')	{	$cond .= ' or stat = "7" ';					}		// 不参加
		$cond .= ' ) ';

		if ($ser_keyword1 <> '')	{
			$cond .= ' and ( ';
			$cond .= ' seminarname like "%'.$ser_keyword1.'%" or ';
			$cond .= ' namae like "%'.$ser_keyword1.'%" or ';
			$cond .= ' furigana like "%'.$ser_keyword1.'%" or ';
			$cond .= ' tel like "%'.$ser_keyword1.'%" or ';
			$cond .= ' email like "%'.$ser_keyword1.'%" ) ';
		}
		if ($ser_keyword2 <> '')	{
			$cond .= ' and ( ';
			$cond .= ' seminarname like "%'.$ser_keyword2.'%" or ';
			$cond .= ' namae like "%'.$ser_keyword2.'%" or ';
			$cond .= ' furigana like "%'.$ser_keyword2.'%" or ';
			$cond .= ' tel like "%'.$ser_keyword2.'%" or ';
			$cond .= ' email like "%'.$ser_keyword2.'%" ) ';
		}
		if ($ser_keyword3 <> '')	{
			$cond .= ' and ( ';
			$cond .= ' seminarname like "%'.$ser_keyword3.'%" or ';
			$cond .= ' namae like "%'.$ser_keyword3.'%" or ';
			$cond .= ' furigana like "%'.$ser_keyword3.'%" or ';
			$cond .= ' tel like "%'.$ser_keyword3.'%" or ';
			$cond .= ' email like "%'.$ser_keyword3.'%" ) ';
		}
		if ($ser_seminarid <> '')	{
			$cond .= ' and seminarid = '.$ser_seminarid;
		}
		if ($ser_hiduke <> '')	{
			$cond .= ' and entrylist.insdate >= "'.$ser_hiduke.' 00:00:00"';
		}
		if ($ser_hiduketo <> '')	{
			$cond .= ' and entrylist.insdate <= "'.$ser_hiduketo.' 23:59:59"';
		}

		$ini = parse_ini_file('../../../bin/pdo_mail_list.ini', FALSE);

		$msg  = '';
		$msg .= '"状態"';
		$msg .= ',"名前"';
		$msg .= ',"フリガナ"';
		$msg .= ',"電話番号"';
		$msg .= ',"メール"';
		$msg .= ',"興味国"';
		$msg .= ',"出発時期"';
		$msg .= ',"その他"';
		$msg .= ',"人数"';
		$msg .= ',"CRMID"';
		$msg .= ',"セミナー日時"';
		$msg .= ',"開催地コード"';
		$msg .= ',"セミナー名"';
		$msg .= ',"予約日"';
		$msg .= chr(13).chr(10);

		try {
			$stt = $db->prepare('SELECT entrylist.id, seminarid, seminarname, namae, furigana, tel, email, ninzu, stat, wait, kyomi, jiki, sonota, insdate, customid, event_list.hiduke, date_format(starttime,\'%H:%i\') as sttime, event_list.place FROM entrylist, event_list WHERE entrylist.seminarid = event_list.id and '.$cond.' ORDER BY seminarid, wait, id, furigana');
			$stt->execute();
			$idx = 0;
			while($row = $stt->fetch(PDO::FETCH_ASSOC)){
				$idx++;
				$cur_id = $row['id'];
				$cur_seminarid = $row['seminarid'];
				$cur_seminarname = $row['seminarname'];
				$cur_namae = $row['namae'];
				$cur_furigana = $row['furigana'];
				$cur_tel = $row['tel'];
				$cur_email = $row['email'];
				$cur_ninzu = $row['ninzu'];
				$cur_stat = $row['stat'];
				$cur_wait = $row['wait'];
				$cur_kyomi = $row['kyomi'];
				$cur_jiki = $row['jiki'];
				$cur_sonota = $row['sonota'];
				$cur_insdate = $row['insdate'];
				$cur_customid = $row['customid'];
				$cur_place = $row['place'];
				$cur_hiduke = $row['hiduke'];
				$cur_sttime = $row['sttime'];

				switch ($cur_stat)	{
					case '0':
						$msg .= '仮予約';
						break;
					case '1':
						$msg .= '予約';
						break;
					case '2':
						$msg .= '参加（終了）';
						break;
					case '3':
						$msg .= '携帯仮予約';
						break;
					case '5':
						$msg .= '自動キャンセル';
						break;
					case '6':
						$msg .= 'キャンセル';
						break;
					case '7':
						$msg .= '不参加（終了）';
						break;
				}
				if ($cur_wait == '1')	{
					$msg .= '(CXL待ち)';
				}
				$msg .= ',"'.$cur_namae.'"';
				$msg .= ',"'.$cur_furigana.'"';
				$msg .= ',"\''.$cur_tel.'"';
				$msg .= ',"'.$cur_email.'"';
				$msg .= ',"'.$cur_kyomi.'"';
				$msg .= ',"'.$cur_jiki.'"';
				$msg .= ',"'.$cur_sonota.'"';
				$msg .= ',"'.$cur_ninzu.'"';
				$msg .= ',"'.$cur_customid.'"';
				$msg .= ',"'.$cur_hiduke.' '.$cur_sttime.'"';
				$msg .= ',"'.$cur_place.'"';
				$msg .= ',"'.$cur_seminarname.'"';
				$msg .= ',"'.$cur_insdate.'"';
				$msg .= chr(13).chr(10);
			}
		} catch (PDOException $e) {
			die($e->getMessage());
		}

		if ($type == 'out')	{
			$body[] = $msg;
		}else{
			$arr = array(
				array(
				"result" => "OK",
				"msg"  => "該当件数は ".$idx."件 です。"
				)
			);
			$msg = json_encode($arr);
			$body[] .= $msg;
		}

		break;

	case "yoyakulist_csv":
		// 当日予約者リストＣＳＶ出力

		$type = fnc_getpost('type');
		$seminardate  = fnc_getpost('seminardate');
		$seminarplace = fnc_getpost('seminarplace');

		$ini = parse_ini_file('../../../bin/pdo_mail_list.ini', FALSE);

		$cond  = ' event_list.hiduke = "'.$seminardate.'"';
		$cond .= ' and event_list.place = "'.$seminarplace.'"';

		$cond .= ' and ( ';
		$cond .= '    stat = "0" or stat = "3" ';		// 仮予約
		$cond .= ' or stat = "1" ';						// 予約
		$cond .= ' or stat = "2" ';						// 参加
		$cond .= ' or stat = "7" ';						// 不参加
		$cond .= ' ) ';

		$msg  = '';
		$msg .= '"NO"';
		$msg .= ',"状態"';
		$msg .= ',"名前"';
		$msg .= ',"フリガナ"';
		$msg .= ',"電話番号"';
		$msg .= ',"メール"';
		$msg .= ',"興味国"';
		$msg .= ',"出発時期"';
		$msg .= ',"その他"';
		$msg .= ',"人数"';
		$msg .= ',"CRMID"';
		$msg .= ',"セミナー日時"';
		$msg .= ',"開催地コード"';
		$msg .= ',"セミナー名"';
		$msg .= ',"予約日"';
		$msg .= ',"重複"';
		$msg .= ',"重複時間"';
		$msg .= ',"重複内容"';
		$msg .= chr(13).chr(10);

		try {
			$stt = $db->prepare('SELECT entrylist.id, seminarid, seminarname, namae, furigana, tel, email, ninzu, stat, wait, kyomi, jiki, sonota, insdate, customid, event_list.hiduke, date_format(starttime,\'%H:%i\') as sttime, event_list.place FROM entrylist, event_list WHERE entrylist.seminarid = event_list.id and '.$cond.' ORDER BY starttime, seminarid, wait, id, furigana');
			$stt->execute();
			$idx = 0;
			while($row = $stt->fetch(PDO::FETCH_ASSOC)){
				$idx++;
				$cur_id = $row['id'];
				$cur_seminarid = $row['seminarid'];
				$cur_seminarname = strip_tags($row['seminarname']);
				$cur_namae = $row['namae'];
				$cur_furigana = $row['furigana'];
				$cur_tel = $row['tel'];
				$cur_email = $row['email'];
				$cur_ninzu = $row['ninzu'];
				$cur_stat = $row['stat'];
				$cur_wait = $row['wait'];
				$cur_kyomi = $row['kyomi'];
				$cur_jiki = $row['jiki'];
				$cur_sonota = $row['sonota'];
				$cur_insdate = $row['insdate'];
				$cur_customid = $row['customid'];
				$cur_place = $row['place'];
				$cur_hiduke = $row['hiduke'];
				$cur_sttime = $row['sttime'];

				$cond2  = $cond;
				$cond2 .= ' and entrylist.id <> '.$cur_id;
				$cond2 .= ' and ( 1 = 0 ';
				if ($cur_tel <> '')	{
					$cond2 .= ' or tel = "'.$cur_tel.'" ';
				}
				if ($cur_email <> '')	{
					$cond2 .= ' or email = "'.$cur_email.'" ';
				}
				if ($cur_namae <> '')	{
					$cond2 .= ' or namae = "'.$cur_namae.'" ';
				}
				if ($cur_furigana <> '')	{
					$cond2 .= ' or furigana = "'.$cur_furigana.'" ';
				}
				$cond2 .= ' ) ';

				$stt2 = $db->prepare('SELECT entrylist.id, seminarid, seminarname, k_title2, namae, furigana, tel, email, ninzu, stat, wait, kyomi, jiki, sonota, insdate, customid, event_list.hiduke, date_format(starttime,\'%H:%i\') as sttime, event_list.place FROM entrylist, event_list WHERE entrylist.seminarid = event_list.id and '.$cond2.' ORDER BY starttime, seminarid, wait, id, furigana');
				$stt2->execute();
				$dup = 0;
				while($row2 = $stt2->fetch(PDO::FETCH_ASSOC)){
					$dup++;
					$msg_dup_id   = $row2['id'];
					$msg_dup_time = $row2['sttime'];
					$msg_dup_name = strip_tags($row2['seminarname']);
					break;
				}
				$stt2 = null;

				if ($dup == 0)	{
					$msg_dup = '';
					$msg_dup_name = '';
					$msg_dup_time = '';
				}else{
					$msg_dup = '○先予約';
					if ($cur_sttime == $msg_dup_time)	{
						if ($cur_id > $msg_dup_id)	{
							$msg_dup = '×後予約';
						}
					}else{
						if ($cur_sttime > $msg_dup_time)	{
							$msg_dup = '×後予約';
						}
					}
				}

				$msg .= $idx.',';
				switch ($cur_stat)	{
					case '0':
						$msg .= '仮予約';
						break;
					case '1':
						$msg .= '予約';
						break;
					case '2':
						$msg .= '参加（終了）';
						break;
					case '3':
						$msg .= '携帯仮予約';
						break;
					case '5':
						$msg .= '自動キャンセル';
						break;
					case '6':
						$msg .= 'キャンセル';
						break;
					case '7':
						$msg .= '不参加（終了）';
						break;
				}
				if ($cur_wait == '1')	{
					$msg .= '(CXL待ち)';
				}
				$msg .= ',"'.$cur_namae.'"';
				$msg .= ',"'.$cur_furigana.'"';
				$msg .= ',"\''.$cur_tel.'"';
				$msg .= ',"'.$cur_email.'"';
				$msg .= ',"'.$cur_kyomi.'"';
				$msg .= ',"'.$cur_jiki.'"';
				$msg .= ',"'.$cur_sonota.'"';
				$msg .= ',"'.$cur_ninzu.'"';
				$msg .= ',"'.$cur_customid.'"';
				$msg .= ',"'.$cur_hiduke.' '.$cur_sttime.'"';
				$msg .= ',"'.$cur_place.'"';
				$msg .= ',"'.$cur_seminarname.'"';
				$msg .= ',"'.$cur_insdate.'"';

				$msg .= ',"'.$msg_dup.'"';
				$msg .= ',"'.$msg_dup_time.'"';
				$msg .= ',"'.$msg_dup_name.'"';

				$msg .= chr(13).chr(10);
			}
		} catch (PDOException $e) {
			die($e->getMessage());
		}

		if ($type == 'out')	{
			$body[] = $msg;
		}else{
			$arr = array(
				array(
				"result" => "OK",
				"msg"  => "該当件数は ".$idx."件 です。"
				)
			);
			$msg = json_encode($arr);
			$body[] .= $msg;
		}

		break;

	case "yoyaku_sendmail":
		// 確認メール送信
		$cur_id = fnc_getpost('id');

		try {
			$stt = $db->prepare('SELECT id, tel, email, kyomi, jiki, sonota, insdate FROM entrylist WHERE id = '.$cur_id.' ORDER BY id');
			$stt->execute();
			$idx = 0;
			$cur_email = '';
			while($row = $stt->fetch(PDO::FETCH_ASSOC)){
				$idx++;
				$cur_email = $row['email'];
			}
		} catch (PDOException $e) {
			die($e->getMessage());
		}

		if ($cur_email <> '')	{
			// 確認メールを送信
			$subject = "イベント（セミナー）のご案内";
			$mail  = '';
			$mail .= '日本ワーキングホリデー協会です。';
			$mail .= chr(10);
			$mail .= 'イベント（セミナー）のご予約状態をご案内する為、このメールをお送りしております。';
			$mail .= chr(10);
			$mail .= chr(10);
			$mail .= '現在の予約状態を確認する場合は、以下のURLを表示してください。';
			$mail .= chr(10);
			$mail .= 'http://www.jawhm.or.jp/yoyaku/disp/'.$cur_id.'/'.md5($cur_email);
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
			mb_send_mail($cur_email,$subject,$mail,"From:".$from);
			$msg = $cur_email.'にメールを送信しました。';
		}else{
			$msg = 'メールアドレスが登録されていません。';
		}
		$body[] .= $msg;

		break;

	case "yoyaku_cancel":
		// 予約キャンセル
		$cur_id = fnc_getpost('id');

		try {
			$stt = $db->prepare('SELECT id, seminarid, ninzu, stat, wait FROM entrylist WHERE id = '.$cur_id.' ORDER BY id');
			$stt->execute();
			$idx = 0;
			$cur_email = '';
			while($row = $stt->fetch(PDO::FETCH_ASSOC)){
				$idx++;
				$cur_seminarid = $row['seminarid'];
				$cur_ninzu = $row['ninzu'];
				$cur_stat = $row['stat'];
				$cur_wait = $row['wait'];
			}
		} catch (PDOException $e) {
			die($e->getMessage());
		}

		try {
			if ($cur_wait == '1')	{
				// ウェイティング状態の場合
				$sql = 'UPDATE event_list SET waitting = waitting - '.$cur_ninzu.' WHERE id = '.$cur_seminarid;
				$stt = $db->prepare($sql);
				$stt->execute();
			}else{
				// 通常予約の場合
				$sql = 'UPDATE event_list SET booking = booking - '.$cur_ninzu.' WHERE id = '.$cur_seminarid;
				$stt = $db->prepare($sql);
				$stt->execute();
			}
			// 予約状態変更
			$sql = 'UPDATE entrylist SET stat = "6", wait = "0" WHERE id = '.$cur_id;
			$stt = $db->prepare($sql);
			$stt->execute();
		} catch (PDOException $e) {
			die($e->getMessage());
		}

		// カレンダー変更
		GC_Edit($cur_seminarid);

		$arr = array(
			array(
			"result" => "OK",
			"msg"  => "キャンセルしました"
			)
		);
		$msg = json_encode($arr);
		$body[] .= $msg;

		break;

	case "yoyaku_kakutei":
		// 予約確定
		$cur_id = fnc_getpost('id');

		try {
			$stt = $db->prepare('SELECT id, seminarid, ninzu, stat, wait FROM entrylist WHERE id = '.$cur_id.' ORDER BY id');
			$stt->execute();
			$idx = 0;
			$cur_email = '';
			while($row = $stt->fetch(PDO::FETCH_ASSOC)){
				$idx++;
				$cur_seminarid = $row['seminarid'];
				$cur_ninzu = $row['ninzu'];
				$cur_stat = $row['stat'];
				$cur_wait = $row['wait'];
			}
		} catch (PDOException $e) {
			die($e->getMessage());
		}

		try {
			// 予約状態変更
			$sql = 'UPDATE entrylist SET stat = "1", wait = "0" WHERE id = '.$cur_id;
			$stt = $db->prepare($sql);
			$stt->execute();
		} catch (PDOException $e) {
			die($e->getMessage());
		}

		// カレンダー変更
		GC_Edit($cur_seminarid);

		$arr = array(
			array(
			"result" => "OK",
			"msg"  => "予約を確定しました"
			)
		);
		$msg = json_encode($arr);
		$body[] .= $msg;

		break;

	case "yoyaku_kuriage":
		// 繰上げ予約
		$cur_id = fnc_getpost('id');

		try {
			$stt = $db->prepare('SELECT id, namae, email, seminarid, ninzu, stat, wait FROM entrylist WHERE id = '.$cur_id.' ORDER BY id');
			$stt->execute();
			$idx = 0;
			$cur_email = '';
			while($row = $stt->fetch(PDO::FETCH_ASSOC)){
				$idx++;
				$cur_seminarid = $row['seminarid'];
				$cur_ninzu = $row['ninzu'];
				$cur_stat = $row['stat'];
				$cur_wait = $row['wait'];
				$cur_namae = $row['namae'];
				$cur_yoyakuid = $row['id'];
				$cur_email = $row['email'];
			}
		} catch (PDOException $e) {
			die($e->getMessage());
		}

		try {
			$stt2 = $db->prepare('SELECT id, place, hiduke, year(hiduke) as y, month(hiduke) as m, day(hiduke) as d, date_format(hiduke,\'%w\') as yobi, date_format(starttime,\'%k:%i\') as sttime, k_title1, pax, booking, waitting FROM event_list WHERE id = "'.$cur_seminarid.'"');
			$stt2->execute();
			$cur_pax = 0;
			$cur_booking = 0;
			$cur_title1 = '';
			while($row2 = $stt2->fetch(PDO::FETCH_ASSOC)){
				// イベント情報読み込み
				$cur_place = $row2['place'];
				$cur_hiduke = $row2['hiduke'];
				$cur_y = $row2['y'];
				$cur_m = $row2['m'];
				$cur_d = $row2['d'];
				$cur_yobi = $row2['yobi'];
				$cur_sttime = $row2['sttime'];
				$cur_title1 = $row2['k_title1'];
				$cur_pax = $row2['pax'];
				$cur_booking = $row2['booking'];
				$cur_waitting = $row2['waitting'];
			}
		} catch (PDOException $e) {
			die($e->getMessage());
		}

		try {
			// 予約状況変更
			$sql  = 'UPDATE entrylist SET ';
			$sql .= '  wait = "0"';
			$sql .= ' ,upddate = "'.date('Y/m/d H:i:s').'"';
			$sql .= ' WHERE id = "'.$cur_id.'"';
			$stt = $db->prepare($sql);
			$stt->execute();

			// 席数変更
			$sql = 'UPDATE event_list SET booking = booking + '.$cur_ninzu.' , waitting = waitting - '.$cur_ninzu.' WHERE id = '.$cur_seminarid;
			$stt = $db->prepare($sql);
			$stt->execute();

			// メール送信
			$subject = '仮予約のお知らせ';
			$body1  = '';
			$body1 .= 'ご予約頂きました以下のイベント（セミナー）ですが、空きが出来ましたのでお席の用意が出来る状態となりました。';
			$body1 .= chr(10);
			$body1 .= 'なお、現在は「仮予約」の状態ですので以下のURLを表示し、必ずご予約を確定させてください。';
			$body1 .= chr(10);
			$body1 .= 'また、ご予約が確定されない場合、２４時間で自動的にこの仮予約はキャンセルされます。ご注意ください。';
			$body2  = '';
			sendmail($subject, $body1, $body2, $cur_namae, $cur_place, $cur_y, $cur_m, $cur_d, $cur_yobi, $cur_sttime, $cur_title1, $cur_yoyakuid, $cur_email);

		} catch (PDOException $e) {
			die($e->getMessage());
		}

		// カレンダー変更
		GC_Edit($cur_seminarid);

		$arr = array(
			array(
			"result" => "OK",
			"msg"  => "繰上予約しました"
			)
		);
		$msg = json_encode($arr);
		$body[] .= $msg;

		break;

	case "yoyaku_shusseki":
		// 参加登録
		$cur_id = fnc_getpost('id');

		try {
			$stt = $db->prepare('SELECT id, seminarid, seminarname, customid, tel, email FROM entrylist WHERE id = '.$cur_id.' ORDER BY id');
			$stt->execute();
			while($row = $stt->fetch(PDO::FETCH_ASSOC)){
				$cur_seminarid = $row['seminarid'];
				$cur_seminarname = $row['seminarname'];
				$cur_customid = $row['customid'];
				$cur_tel = $row['tel'];
				$cur_email = $row['email'];
			}
		} catch (PDOException $e) {
			die($e->getMessage());
		}

		try {
			$stt = $db->prepare('SELECT id, crmid FROM event_list WHERE id = '.$cur_seminarid.' ORDER BY id');
			$stt->execute();
			while($row = $stt->fetch(PDO::FETCH_ASSOC)){
				$cur_crmid = $row['crmid'];
			}
		} catch (PDOException $e) {
			die($e->getMessage());
		}

		try {
			// 予約状態変更
			$sql = 'UPDATE entrylist SET stat = "2", wait = "0" WHERE id = '.$cur_id;
			$stt = $db->prepare($sql);
			$stt->execute();
		} catch (PDOException $e) {
			die($e->getMessage());
		}

		// ＣＲＭに転送
		$data = array(
				 'pwd' => '303pittST'
				,'act' => 'shusseki'
				,'edit_seminarid' => $cur_seminarid
				,'edit_seminarname' => $cur_seminarname
				,'edit_customid' => $cur_customid
				,'edit_crmid' => $cur_crmid
				,'edit_tel' => $cur_tel
				,'edit_email' => $cur_email
		);

		$url = 'https://toratoracrm.com/crm/';
		$val = wbsRequest($url, $data);
		$ret = json_decode($val, true);

		// カレンダー変更
		GC_Edit($cur_seminarid);

		$arr = array(
			array(
			"result" => "OK",
			"msg"  => "参加登録しました"
			)
		);
		$msg = json_encode($arr);
		$body[] .= $msg;

		break;

	case "ikkatu_shusseki":
		// 一括参加登録
		$edit_ids = fnc_getpost('id');

		$arr_id = explode(',' , $edit_ids);

		$err_msg = '';
		$tbl_msg = '';

		try {
			$no  = 0;
			$idx = 0;
			while ($idx<count($arr_id))	{
				$stt = $db->prepare('SELECT id, seminarid, seminarname, namae, furigana, tel, email, stat, wait FROM entrylist WHERE id = '.$arr_id[$idx].'');
				$stt->execute();
				while($row = $stt->fetch(PDO::FETCH_ASSOC)){
					$cur_id = $row['id'];
					$cur_namae = $row['namae'];
					$cur_stat = $row['stat'];
					$cur_wait = $row['wait'];
				}

				$no++;
				$tbl_msg .= '<tr>';
				$tbl_msg .= '<td style="border-bottom:1px dotted navy;">&nbsp;'.$cur_namae.'&nbsp;</td>';
				$tbl_msg .= '<td style="border-bottom:1px dotted navy;">';
				$tbl_msg .= '<input type="hidden" name="id_'.$no.'" value="'.$cur_id.'">';
				$tbl_msg .= '&nbsp;';

				if ($cur_wait == '1')	{
					$tbl_msg .= 'ＣＸＬ待ち';
				}
				switch ($cur_stat)	{
					case '0':
						$tbl_msg .= '仮予約';
						break;
					case '1':
						$tbl_msg .= '予約';
						break;
					case '2':
						$tbl_msg .= '参加（終了）';
						break;
					case '3':
						$tbl_msg .= '携帯仮予約';
						break;
					case '5':
						$tbl_msg .= '自動キャンセル';
						break;
					case '6':
						$tbl_msg .= 'キャンセル';
						break;
					case '7':
						$tbl_msg .= '不参加（終了）';
						break;
				}
				$tbl_msg .= '&nbsp;</td>';
				$tbl_msg .= '</tr>';

				$idx++;
			}

		} catch (PDOException $e) {
			die($e->getMessage());
		}
		$tbl_msg .= '<input type="hidden" name="linecnt" value="'.$no.'">';

		$msg  = '';
		$msg .= '
				<div id="div_card_edit" style="display:none; margin:10px 20px 10px 20px; font-size:10pt; cursor:default;">
					<div style="margin:0 0 10px 0; font-size:12pt; font-weight:bodl;">【セミナー参加一括登録】</div>
					<p>登録対象　：　'.$no.'名　　　以下の方を一括して参加登録します。</p>
					<div style="width:380px; height:340px; overflow: scroll;">';
		$msg .= '		<form id="form_card_edit">
						<table border="1">
							<tr>
								<th>名前</th>
								<th>状態</th>
							</tr>
		';
		$msg .= $tbl_msg;
		$msg .= '
				</table>
			</form>
		</div>
				<div style="text-align:right; width:380px; margin-top:10px;">
					<input type=button class="button_cancel" value="やめる" onclick="fncHide();">&nbsp;&nbsp;
					<input type=button class="button_submit" value="登録" onclick="fncikkatushussekipost(\'form_card_edit\');">
				</div>
			</div>
		</div>
		';

		$body[] .= $msg;

		break;

	case "ikkatu_shusseki_go":
		// 一括参加登録（登録処理）
		$edit_cnt = fnc_getpost('linecnt');
		$idx = 1;
		$edit_id = array();
		while($idx<=$edit_cnt)	{
			$edit_id[$idx] = fnc_getpost('id_'.$idx);
			$idx++;
		}

		$msg = '';

		try {
			$idx = 1;
			while($idx<=count($edit_id))	{

				$stt = $db->prepare('SELECT id, seminarid, seminarname, customid, tel, email FROM entrylist WHERE id = '.$edit_id[$idx].' ORDER BY id');
				$stt->execute();
				while($row = $stt->fetch(PDO::FETCH_ASSOC)){
					$cur_seminarid = $row['seminarid'];
					$cur_seminarname = $row['seminarname'];
					$cur_customid = $row['customid'];
					$cur_tel = $row['tel'];
					$cur_email = $row['email'];
				}

				$stt = $db->prepare('SELECT id, crmid FROM event_list WHERE id = '.$cur_seminarid.' ORDER BY id');
				$stt->execute();
				while($row = $stt->fetch(PDO::FETCH_ASSOC)){
					$cur_crmid = $row['crmid'];
				}

				// 予約状態変更
				$sql = 'UPDATE entrylist SET stat = "2", wait = "0" WHERE id = '.$edit_id[$idx];
				$stt = $db->prepare($sql);
				$stt->execute();

				// ＣＲＭに転送
				$data = array(
						 'pwd' => '303pittST'
						,'act' => 'shusseki'
						,'edit_seminarid' => $cur_seminarid
						,'edit_seminarname' => $cur_seminarname
						,'edit_customid' => $cur_customid
						,'edit_crmid' => $cur_crmid
						,'edit_tel' => $cur_tel
						,'edit_email' => $cur_email
					);
				$url = 'https://toratoracrm.com/crm/';
				$val = wbsRequest($url, $data);
				$ret = json_decode($val, true);

				$idx++;
			}

			// カレンダー変更
			GC_Edit($cur_seminarid);

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


	case "yoyaku_showdesc":
		// 詳細表示

		$cur_id = fnc_getpost('id');

		try {
			$stt = $db->prepare('SELECT id, tel, email, kyomi, jiki, sonota, insdate, stat FROM entrylist WHERE id = '.$cur_id.' ORDER BY id');
			$stt->execute();
			$idx = 0;
			while($row = $stt->fetch(PDO::FETCH_ASSOC)){
				$idx++;
				$cur_id = $row['id'];
				$cur_tel = $row['tel'];
				$cur_email = $row['email'];
				$cur_kyomi = $row['kyomi'];
				$cur_jiki = $row['jiki'];
				$cur_sonota = $row['sonota'];
				$cur_insdate = $row['insdate'];
				$cur_stat = $row['stat'];
			}
		} catch (PDOException $e) {
			die($e->getMessage());
		}

		$msg  = '<table border="1">';
		$msg .= '<tr><td>'.$cur_tel.'</td><td>'.$cur_email.'</td></tr>';
		$msg .= '<tr><td colspan="2">'.$cur_kyomi.'</td></tr>';
		$msg .= '<tr><td colspan="2">'.$cur_jiki.'</td></tr>';
		$msg .= '<tr><td colspan="2">'.$cur_sonota.'</td></tr>';
		$msg .= '<tr><td colspan="2">登録日 ： '.$cur_insdate.'</td></tr>';
		$msg .= '</table>';
		$msg .= '';

		$body[] .= $msg;

		break;


}


function sendmail($subject, $body1, $body2, $cur_namae, $cur_place, $cur_y, $cur_m, $cur_d, $cur_yobi, $cur_sttime, $cur_title1, $cur_yoyakuid, $cur_email)	{

	if ($cur_email == '')	{
		return true;
	}

	// メール送信
	$youbi = Array("日","月","火","水","木","金","土");

	$body  = '';
	$body .= ''.$cur_namae.'様';
	$body .= chr(10);
	$body .= chr(10);
	$body .= '日本ワーキングホリデー協会です。';
	$body .= chr(10);
	$body .= chr(10);
	if ($body1 <> '')	{
		$body .= $body1;
		$body .= chr(10);
		$body .= chr(10);
	}
	$body .= '---------------';
	$body .= chr(10);
	switch ($cur_place)	{
		case 'tokyo':
			$body .='　東京会場';
			$body .= chr(10);
			$body .='　http://www.jawhm.or.jp/event/map?p=tokyo';
			$body .= chr(10);
			break;
		case 'osaka':
			$body .='　大阪会場';
			$body .= chr(10);
			$body .='　http://www.jawhm.or.jp/event/map?p=osaka';
			$body .= chr(10);
			break;
		case 'nagoya':
			$body .='　名古屋会場';
			$body .= chr(10);
			$body .='　http://www.jawhm.or.jp/event/map?p=nagoya';
			$body .= chr(10);
			break;
		case 'fukuoka':
			$body .='　福岡会場';
			$body .= chr(10);
			$body .='　http://www.jawhm.or.jp/event/map?p=fukuoka';
			$body .= chr(10);
			break;
		case 'sendai':
			$body .='　仙台会場';
			$body .= chr(10);
			break;
		case 'toyama':
			$body .='　富山会場';
			$body .= chr(10);
			break;
		case 'okinawa':
			$body .='　沖縄会場';
			$body .= chr(10);
			$body .='　http://www.jawhm.or.jp/event/map?p=okinawa';
			$body .= chr(10);
			break;
	}
	$body .= '　'.$cur_y.'年 '.$cur_m.'月 '.$cur_d.'日 ('.$youbi[$cur_yobi].'曜日)   '.$cur_sttime.' 開始';
	$body .= chr(10);
	$body .= '　「'.$cur_title1.'」';
	$body .= chr(10);
	$body .= '---------------';
	$body .= chr(10);
	$body .= chr(10);
	if ($body2 <> '')	{
		$body .= $body2;
		$body .= chr(10);
		$body .= chr(10);
	}
	$body .= '';
	$body .= '予約状態の確認・キャンセルなどは以下のURLからどうぞ';
	$body .= chr(10);
	$body .= 'http://www.jawhm.or.jp/yoyaku/disp/'.$cur_yoyakuid.'/'.md5($cur_email);
	$body .= chr(10);
	$body .= '';
    //$from = mb_encode_mimeheader(mb_convert_encoding("日本ワーキングホリデー協会","JIS"))."<info@jawhm.or.jp>";
    $from = mb_encode_mimeheader(mb_convert_encoding("日本ワーキングホリデー協会","JIS"))."<j-doi@plate.co.jp>";
	mb_send_mail($cur_email,$subject,$body,"From:".$from);

}


?>