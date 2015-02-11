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
		// メンバー管理

		// メンバー操作系ＪＳ
		$script .= '
			// カレンダー表示
			InputCalendar.createOnLoaded(\'ser_hiduke\', {lang:\'ja\'});
			InputCalendar.createOnLoaded(\'ser_hiduketo\', {lang:\'ja\'});

			// メンバー検索
			function fncSermemList()	{
				jQuery("#processing").show();
				jQuery.ajax({
					type: "POST",
					url: "'.$url_base.'data/mem/mem_ser",
					data: jQuery("#form_mem_list").serialize(),
					success: function(msg){
						jQuery("#processing").hide();
						jQuery("#res_mem_list").html(msg);
					},
					error:function(){
						jQuery("#processing").hide();
						alert("通信エラーが発生しました。");
					}
				});
			}

			function fncSermemCsv()	{
				jQuery("#processing").show();
				jQuery.ajax({
					type: "POST",
					url: "'.$url_base.'csv/mem/mem_csv",
					data: jQuery("#form_mem_list").serialize(),
					success: function(msg){
						jQuery("#processing").hide();
						res = eval(msg);
						if (res[0].result == \'OK\')	{
							if (confirm(res[0].msg + "出力しますか？"))	{
								window.open(\''.$url_base.'csv/mem/mem_csv/?type=out&\' + jQuery("#form_mem_list").serialize(), \'_blank\', \'width=200,height=200\');
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

			function fncSermemYamato()	{
				jQuery("#processing").show();
				jQuery.ajax({
					type: "POST",
					url: "'.$url_base.'csv/mem/mem_yamato",
					data: jQuery("#form_mem_list").serialize(),
					success: function(msg){
						jQuery("#processing").hide();
						res = eval(msg);
						if (res[0].result == \'OK\')	{
							if (confirm(res[0].msg + "出力しますか？"))	{
								window.open(\''.$url_base.'csv/mem/mem_yamato/?type=out&\' + jQuery("#form_mem_list").serialize(), \'_blank\', \'width=200,height=200\');
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

			// 選択チェック
			function fncallcheck(obj)	{
				jQuery(obj.parentNode.parentNode.parentNode).find("input[type=\'checkbox\']").attr("checked", obj.checked);
			}

			// 発送手配
			function fnccardsend()	{
				var chk = jQuery( "input:checked" ).map( function() { return jQuery(this).attr("ap"); }).get().join(",");
				if (chk == \'\')	{
					alert("発送手配の対象を選択してください。");
				}else{
					jQuery("#processing").show();
					jQuery.ajax({
						type: "POST",
						url: "'.$url_base.'data/mem/mem_cardsend",
						data: "id=" + chk,
						success: function(msg){
							jQuery("#processing").hide();
							jQuery("#res_mem_edit").html(msg);
							fncShow(\'div_card_edit\', 600, 600);
						},
						error:function(){
							jQuery("#processing").hide();
							alert("通信エラーが発生しました。");
						}
					});
				}
			}

			// 一括カード発行
			function fnccardprint()	{
				var chk = jQuery( "input:checked" ).map( function() { return jQuery(this).attr("ap"); }).get().join(",");
				if (chk == \'\')	{
					alert("発行対象を選択してください。");
				}else{
					if (!confirm(\'メンバーカードを一括発行します。よろしいですか？\'))	{
						return false;
					}
					jQuery( "input:checked" ).map( function() {
						var id = String(jQuery(this).attr("ap"));
						if (id.substring(0,2) == \'JW\')	{
							window.open(\''.$url_base.'data/mem/card/\' + id, \'_blank\', \'width=990,height=400\');
						}
						return jQuery(this).attr("ap");
					}).get().join(",");
				}
			}

			// 一括カード発行２
			function fnccardprint2()	{
				var chk = jQuery( "input:checked" ).map( function() { return jQuery(this).attr("ap"); }).get().join(",");
				if (chk == \'\')	{
					alert("発行対象を選択してください。");
				}else{
					if (!confirm(\'新メンバーカードを一括発行します。よろしいですか？\'))	{
						return false;
					}
					jQuery( "input:checked" ).map( function() {
						var id = String(jQuery(this).attr("ap"));
						if (id.substring(0,2) == \'JW\')	{
							window.open(\''.$url_base.'data/mem/card2/\' + id, \'_blank\', \'width=990,height=400\');
						}
						return jQuery(this).attr("ap");
					}).get().join(",");
				}
			}

			// 選択行強調
			function fncgetfocus(obj)	{
				jQuery(obj.parentNode.parentNode).css("background","navy");
				jQuery(obj.parentNode.parentNode).css("color","white");
				jQuery(obj).select();
			}
			function fnclostfocus(obj)	{
				jQuery(obj.parentNode.parentNode).css("background","white");
				jQuery(obj.parentNode.parentNode).css("color","black");
				var mae = String(obj.value);
				var ato = \'\';
				for (var idx=0; idx<mae.length; idx++)	{
					if (mae.substr(idx,1) == \'A\' || mae.substr(idx,1) == \'a\')	{
						null;
					}else{
						ato += mae.substr(idx,1);
					}
				}
				obj.value = ato;
			}

			// 発送手配入力チェック
			function fnccardpost(formname)	{
				var objform = document.getElementById(formname);
				var obj = objform.getElementsByTagName(\'input\');
				for (idx=0; idx<obj.length; idx++)	{
					if (obj[idx].value == \'\')	{
						alert("入力してください");
						obj[idx].focus();
						return false;
					}
				}
				if (!confirm(\'発送手配を登録します。よろしいですか？\'))	{
					return false;
				}
				jQuery("#processing").show();
				jQuery.ajax({
					type: "POST",
					url: "'.$url_base.'data/mem/mem_cardsend_set",
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


			// メンバー表示リクエスト
			function fncmemShow(id)	{
				jQuery("#processing").show();
				jQuery.ajax({
					type: "POST",
					url: "'.$url_base.'data/mem/mem_show",
					data: "id=" + id,
					success: function(msg){
						jQuery("#processing").hide();
						jQuery("#res_mem_edit").html(msg);
						fncShow(\'div_mem_edit\', 800, 600);
					},
					error:function(){
						jQuery("#processing").hide();
						alert("通信エラーが発生しました。");
					}
				});
			}

			// メンバー入力チェック
			function fncmemPost(formname)	{
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
				jQuery("#processing").show();
				jQuery.ajax({
					type: "POST",
					url: "'.$url_base.'data/mem/mem_edit",
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
			function fncsendmail()	{
				if (jQuery("#edit_email").val() == "")	{
					alert("メールアドレスが入力されていません。");
					return false;
				}
				if (confirm("確認メールをお送りします。よろしいですか？"))	{
					jQuery("#processing").show();
					jQuery.ajax({
						type: "POST",
						url: "'.$url_base.'data/mem/mem_sendmail",
						data: "email=" + jQuery("#edit_email").val(),
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

			// 状態変更
			function fncstatechange(state)	{
				jQuery("#processing").show();
				jQuery.ajax({
					type: "POST",
					url: "'.$url_base.'data/mem/mem_state",
					data: "state=" + state,
					success: function(msg){
						jQuery("#processing").hide();
						jQuery("#edit_state").val(state);
						jQuery("#div_state").html(msg);
					},
					error:function(){
						jQuery("#processing").hide();
						alert("通信エラーが発生しました。");
					}
				});
			}

			// アンケート表示
			function fncshowquest(id)	{
				if (jQuery("#div_quest").css("display") == "block")	{
					jQuery("#div_quest").hide();
				}else{
					jQuery("#processing").show();
					jQuery.ajax({
						type: "POST",
						url: "'.$url_base.'data/mem/show_quest",
						data: "id=" + id,
						success: function(msg){
							jQuery("#processing").hide();
							jQuery("#div_quest").html(msg);
							jQuery("#div_quest").show();
						},
						error:function(){
							jQuery("#processing").hide();
							alert("通信エラーが発生しました。");
						}
					});
				}
			}

			// 支払状況表示
			function fncshowpayment()	{
				if (jQuery("#payment_div").css("display") == "block")	{
					jQuery("#payment_div").hide();
				}else{
					jQuery("#payment_div").show();
				}
			}

			// ＣＲＭ転送
			function fncsendcrm(sbt,id)	{
				jQuery("#processing").show();
				jQuery.ajax({
					type: "POST",
					url: "'.$url_base.'data/mem/send_crm",
					data: "sbt=" + sbt + "&id=" + id,
					success: function(msg){
						jQuery("#processing").hide();
						alert(msg);
						jQuery.unblockUI();
					},
					error:function(){
						jQuery("#processing").hide();
						alert("通信エラーが発生しました。");
					}
				});
			}
		';

		// 検索画面表示
		$body_title[] .= 'メンバー検索';
		$body[] .= '
			<form id="form_mem_list">
				<table>
					<tr>
						<td style="text-align:right;">名前</td><td>'.field_text('ser_namae', 20, '').'</td>
						<td style="text-align:right;">登録日</td>
						<td colspan="3">
							<input id="ser_hiduke" name="ser_hiduke" size="16" type="text" />
							　～　
							<input id="ser_hiduketo" name="ser_hiduketo" size="16" type="text" />
						</td>
					</tr>
					<tr>
						<td style="text-align:right;">電話番号</td><td>'.field_text('ser_tel', 20, '').'</td>
						<td style="text-align:right;">　メール</td><td>'.field_text('ser_email', 20, '').'</td>
						<td style="text-align:right;">　会員番号</td><td>'.field_text('ser_id', 20, '').'</td>
					</tr>
					<tr>
						<td style="text-align:right;">メモ</td>
						<td colspan="5">'.field_text('ser_memo', 120, '').'</td>
					</tr>
					<tr>
						<td style="text-align:right;">状態</td>
						<td colspan="5">
							<input type="checkbox" name="stat0">仮登録　
							<input type="checkbox" name="stat1">メアド承認　
							<input type="checkbox" name="stat5" checked>通常　
							<input type="checkbox" name="stat9">期限切れ
							<input type="checkbox" name="statA"><span style="color:navy;">支払済み</span>　　　
							<select name="ser_memcard">
								<option value="">全て</option>
								<option value="未発行">未発行</option>
								<option value="発送済み">発送済み</option>
								<option value="住所不明">住所不明</option>
								<option value="手渡し予定">手渡し予定</option>
								<option value="手渡し済">手渡し済</option>
								<option value="その他">その他</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>
							<input class="button_csv" type="button" value="CSV" id="sermemcsv" onclick="fncSermemCsv();"">
						</td>
						<td>
							<input class="button_csv" type="button" value="ヤマト" id="sermemyamato" onclick="fncSermemYamato();"">
						</td>
						<td>
							<input class="button" type="button" value="発送手配" id="cardsend" onclick="fnccardsend();"">
<!--
							<input class="button" type="button" value="カード発行" id="cardsend" onclick="fnccardprint();"">
-->
							<input class="button" type="button" value="新C" id="cardsend" onclick="fnccardprint2();"">
							</td>
						<td colspan="4" style="text-align:right;">
								<input class="button_cancel" type="reset" value="clear" onclick="jQuery(\'#res_mem_list\').html(\'\');">&nbsp;&nbsp;
								<input class="button_submit" type="button" value="Search" onclick="fncSermemList();"">
						</td>
					</tr>
				</table>
			</form>
			<div id="res_mem_list" style=""></div>
		';

		// 新規登録表示
		$body_title[] .= '新規メンバー';
		$body[] .= '
			<input type=button class="button_save" value="　新しいメンバーを登録する" onclick="fncmemShow(\'\');">
			<div id="res_mem_edit" style=""></div>
		';

		break;
	case "mem_show":
		// メンバー編集（新規）
		$id = fnc_getpost('id');
		$cur_id = $id;

		if ($id == '')	{
			$title = '【新しいメンバを登録する】';
			$iddata = '<input type="hidden" name="id" value="">';

			$cur_email = '';
			$cur_namae = '';
			$cur_furigana = '';
			$cur_gender = 'f';
			$cur_year = '';
			$cur_month = '';
			$cur_day = '';
			$cur_pcode = '';
			$cur_add1 = '';
			$cur_add2 = '';
			$cur_add3 = '';
			$cur_tel = '';
			$cur_mailsend = '1';
			$cur_indate = '';
			$cur_orderid = '';
			$cur_orderdate = '';
			$cur_state = '0';
			$cur_memo = '';
			$cur_memcard = '';
			$cur_meilcheck = '';
			$cur_kyoten = '';
			$cur_payment = '';
			$cur_mailcheck = '';
			$cur_payment_url = '';
			$cur_payment_nb = '';
			$cur_payment_expired_date = '';

		}else{
			$title = '【メンバ情報修正】';
			$iddata = '<input type="hidden" name="id" value="'.$id.'">';
			try {
				$sql  = '';
				$sql .= 'SELECT';
				$sql .= '  id';
				$sql .= ', email';
				$sql .= ', namae';
				$sql .= ', furigana';
				$sql .= ', gender';
				$sql .= ', birth';
				$sql .= ', year(birth) as yy';
				$sql .= ', month(birth) as mm';
				$sql .= ', day(birth) as dd';
				$sql .= ', pcode';
				$sql .= ', add1';
				$sql .= ', add2';
				$sql .= ', add3';
				$sql .= ', tel';
				$sql .= ', state';
				$sql .= ', indate';
				$sql .= ', mailcheck';
				$sql .= ', mailsend';
				$sql .= ', orderid';
				$sql .= ', orderdate';
				$sql .= ', crmid';
				$sql .= ', crmdate';
				$sql .= ', memo';
				$sql .= ', memcard';
				$sql .= ', kyoten';
				$sql .= ', payment';
				$sql .= ', payment_url';
				$sql .= ', payment_nb';
				$sql .= ', payment_expired_date';
				$sql .= ', attchk';
				$sql .= ' FROM memlist WHERE id = "'.$id.'"';

				$stt = $db->prepare($sql);
				$stt->execute();
				$idx = 0;
				while($row = $stt->fetch(PDO::FETCH_ASSOC)){
					$idx++;
					$cur_email = $row['email'];
					$cur_namae = $row['namae'];
					$cur_furigana = $row['furigana'];
					$cur_gender = $row['gender'];
					$cur_year = $row['yy'];
					$cur_month = $row['mm'];
					$cur_day = $row['dd'];
					$cur_pcode = $row['pcode'];
					$cur_add1 = $row['add1'];
					$cur_add2 = $row['add2'];
					$cur_add3 = $row['add3'];
					$cur_tel = $row['tel'];
					$cur_mailsend = $row['mailsend'];
					$cur_state = $row['state'];
					$cur_indate = $row['indate'];
					$cur_mailcheck = $row['mailcheck'];
					$cur_orderid = $row['orderid'];
					$cur_orderdate = $row['orderdate'];
					$cur_crmid = $row['crmid'];
					$cur_crmdate = $row['crmdate'];
					$cur_memo = $row['memo'];
					$cur_memcard = $row['memcard'];
					$cur_kyoten = $row['kyoten'];
					$cur_payment = $row['payment'];
					$cur_payment_url = $row['payment_url'];
					$cur_payment_nb = $row['payment_nb'];
					$cur_payment_expired_date = $row['payment_expired_date'];
					$cur_attchk = $row['attchk'];
				}
			} catch (PDOException $e) {
				die($e->getMessage());
			}
		}
		$gender['m'] = '';
		$gender['f'] = '';
		$gender[$cur_gender] = ' checked ';

		if ($cur_mailsend == '1')	{
			$mailsend = ' checked ';
		}else{
			$mailsend = '';
		}

		if ($cur_attchk == 1){
			$attchk = ' checked ';
		}else{
			$attchk = '';
		}

		$card = '';
		if ($cur_orderid == '' && $cur_state == '1')	{
			$card = '
				<input type=button value="支払手続き" onclick="window.open(\''.$url_base.'main/zeus/payment/'.$cur_id.'\', \'_blank\', \'width=990,height=400\');jQuery.unblockUI();return false;">
			';
		}
		$memcard = '';
		$quest = '';
		if ($cur_id <> '')	{
			$memcard = '
				<input type=button value="新C" onclick="window.open(\''.$url_base.'data/mem/card2/'.$cur_id.'\', \'_blank\', \'width=990,height=400\');jQuery.unblockUI();return false;">
<!--
				<input type=button value="カード発行" onclick="window.open(\''.$url_base.'data/mem/card/'.$cur_id.'\', \'_blank\', \'width=990,height=400\');jQuery.unblockUI();return false;">
-->
				<input type=button value="仮カード" onclick="window.open(\''.$url_base.'data/mem/precard/'.$cur_id.'\', \'_blank\', \'width=990,height=800\');jQuery.unblockUI();return false;">
				<input type=button value="ＰＷＤ" onclick="if(confirm(\'パスワードがクリアされます。よろしいですか？\')){window.open(\''.$url_base.'data/mem/repwd/'.$cur_id.'\', \'_blank\', \'width=990,height=800\');jQuery.unblockUI();}return false;">
			';
			$quest = '
				<input type=button value="アンケート結果" onclick="fncshowquest(\''.$cur_id.'\');">
			';
		}

		$sel_memcard = array('','','','','','');
		switch ($cur_memcard)	{
			case '未発行':
				$sel_memcard[0] = ' selected ';
				break;
			case '発送済み':
				$sel_memcard[1] = ' selected ';
				break;
			case '手渡し済':
				$sel_memcard[2] = ' selected ';
				break;
			case 'その他':
				$sel_memcard[3] = ' selected ';
				break;
			case '住所不明':
				$sel_memcard[4] = ' selected ';
				break;
			case '手渡し予定':
				$sel_memcard[5] = ' selected ';
				break;
		}

		$sel_kyoten['KT'] = '';
		$sel_kyoten['KO'] = '';
		$sel_kyoten['KN'] = '';
		$sel_kyoten['KF'] = '';
		$sel_kyoten['KK'] = '';
		$sel_kyoten[$cur_kyoten] = ' selected ';

		if ($cur_mailcheck == '')	{
				$keiro = '<span style="padding: 2px 5px 2px 5px; background:black; color:white; font-size:9pt">手動</span>';
		}else{
			if ($cur_kyoten <> '')	{
				$keiro = '<span style="padding: 2px 5px 2px 5px; background:navy; color:white; font-size:9pt">店頭</span>';
			}else{
				if ($cur_mailcheck == '00000')	{
					$keiro = '<span style="padding: 2px 5px 2px 5px; background:navy; color:white; font-size:9pt">店頭</span>';
				}else{
					$keiro = '<span style="padding: 2px 5px 2px 5px; background:orange; color:white; font-size:9pt">ネット</span>';
				}
			}
		}

		$msg = '
			<div id="div_mem_edit" style="display:none; margin:10px 20px 10px 20px; font-size:10pt; cursor:default;">
				<div style="margin:0 0 10px 0; font-size:12pt; font-weight:bodl;">'.$title.'</div>
				<form id="form_mem_edit">
				<table>
					<tr>
						<td class="label">会員番号</td>
						<td class="infield">
							'.$cur_id.'<input type="hidden" name="edit_id" value="'.$cur_id.'">'.$memcard.'
						</td>
						<td class="label">登録拠点</td>
						<td class="infield">

							<select name="edit_kyoten">
								<option value="">ネット申込み</option>
								<option value="KT"'.$sel_kyoten['KT'].'>東京(KT)</option>
								<option value="KO"'.$sel_kyoten['KO'].'>大阪(KO)</option>
								<option value="KN"'.$sel_kyoten['KN'].'>名古屋(KN)</option>
								<option value="KF"'.$sel_kyoten['KF'].'>福岡(KF)</option>
								<option value="KK"'.$sel_kyoten['KK'].'>沖縄(KK)</option>
							</select>
							'.$keiro.'
						</td>
					</tr>
					<tr>
						<td class="label">名前</td>
						<td class="infield" colspan="3">'.field_required('edit_namae', 40, $cur_namae).'　'.$quest.'<br/>
							<div style="display:none;" id="div_quest"></div>
						</td>
					</tr>
					<tr>
						<td class="label">フリガナ</td>
						<td class="infield">'.field_text('edit_furigana', 40, $cur_furigana).'</td>
						<td class="label">電話番号</td>
						<td class="infield">'.field_text('edit_tel', 30, $cur_tel).'</td>
					</tr>
					<tr>
						<td class="label">生年月日</td>
						<td class="infield">'.field_text('edit_year', 4, $cur_year).'年 '.field_text('edit_month', 2, $cur_month).'月 '.field_text('edit_day', 2, $cur_day).'日</td>
						<td class="label">性別</td>
						<td class="infield">
							<input type=radio name="edit_gender" value="m"'.$gender['m'].'>男性　
							<input type=radio name="edit_gender" value="f"'.$gender['f'].'>女性　
						</td>
					</tr>
					<tr>
						<td class="label">現住所</td>
						<td class="infield" colspan="3">
							<table>
								<tr><td>郵便番号</td><td>'.field_text('edit_pcode', 10, $cur_pcode).'</td></tr>
								<tr><td>都道府県</td><td>'.field_text('edit_add1', 40, $cur_add1).'</td></tr>
								<tr><td>市区町村</td><td>'.field_text('edit_add2', 40, $cur_add2).'</td></tr>
								<tr><td>番地・建物名</td><td>'.field_text('edit_add3', 40, $cur_add3).'</td></tr>
							</table>
						</td>
					</tr>
					<tr>
						<td class="label">メール</td>
						<td class="infield">'.field_text('edit_email', 50, $cur_email).'<input type="button" value="確認メール" onclick="fncsendmail();">
						<td class="label">メーリングリスト</td>
						<td class="infield"><input type="checkbox" name="edit_mailsend" '.$mailsend.' >案内する</td>
						</td>
					</tr>
					<tr>
						<td class="label">状態</td>
						<td class="infield" colspan="3"><span id="div_state">'.fnc_state($cur_state).'</span>
							<input type="button" value="メアド承認" onclick="fncstatechange(\'1\');">
							<input type="button" value="通常" onclick="fncstatechange(\'5\');">
							<input type="button" value="期限切れ" onclick="fncstatechange(\'9\');">
							<input type="hidden" id="edit_state" name="edit_state" value="'.$cur_state.'">
						</td>
					</tr>
					<tr>
						<td class="label">登録日</td>
						<td class="infield" colspan="3">'.$cur_indate.'
							　　カード発行状態：
							<select name="edit_memcard">
								<option value="未発行" '.$sel_memcard[0].'>未発行</option>
								<option value="発送済み"'.$sel_memcard[1].'>発送済み</option>
								<option value="住所不明"'.$sel_memcard[4].'>住所不明</option>
								<option value="手渡し予定"'.$sel_memcard[5].'>手渡し予定</option>
								<option value="手渡し済"'.$sel_memcard[2].'>手渡し済</option>
								<option value="その他"'.$sel_memcard[3].'>その他</option>
							</select>
						</td>
					</tr>
					<tr>
						<td class="label">入金情報</td>
						<td class="infield" colspan="3">
							<input type="button" value="+" onclick="fncshowpayment();">
							支払方法:'.$cur_payment.' オーダー番号:'.$cur_orderid.' '.$card.'<br/>
							支払日: '.field_text('edit_orderdate', 30, $cur_orderdate).'
							<div id="payment_div" style="display:none;">
								決済番号:'.$cur_payment_nb.'　<a href="'.$cur_payment_url.'" target="_blank">印刷ページ</a><br/>
								決済期限:'.$cur_payment_expired_date.'
							</div>
						</td>
					</tr>';
		if ($cur_id <> '')	{
			$msg .= '<tr>
						<td class="label">ＣＲＭ連動</td>
						<td class="infield" colspan="3">';
			if ($cur_crmid == '')	{
				$msg .= '<input type="button" value="KT(東京)" onclick="fncsendcrm(\'KT\',\''.$cur_id.'\');">';
				$msg .= '<input type="button" value="KO(大坂)" onclick="fncsendcrm(\'KO\',\''.$cur_id.'\');">';
				$msg .= '<input type="button" value="KN(名古屋)" onclick="fncsendcrm(\'KN\',\''.$cur_id.'\');">';
				$msg .= '<input type="button" value="KF(福岡)" onclick="fncsendcrm(\'KF\',\''.$cur_id.'\');">';
				$msg .= '<input type="button" value="KK(沖縄)" onclick="fncsendcrm(\'KK\',\''.$cur_id.'\');"><br/>';
			}else{
				$msg .= 'ID:'.$cur_crmid.'　Date:'.$cur_crmdate;
			}
			$msg .= '　登録拠点：'.$cur_kyoten;
			$msg .= '</td></tr>';
		}
		$msg .= '	<tr>
						<td class="label">重要メモ<br/>&nbsp;<input type="checkbox" name="edit_attchk" '.$attchk.'>注意情報</td>
						<td class="infield" colspan="3">
							<textarea name="edit_memo" rows="1" cols="60">'.$cur_memo.'</textarea>
					</tr>
					<tr>
						<td colspan="4" style="text-align:right;">
							<input type=button class="button_cancel" value="やめる" onclick="fncHide();">&nbsp;&nbsp;
							<input type=button class="button_submit" value="登録" onclick="fncmemPost(\'form_mem_edit\');">
						</td>
					</tr>
				</table>
				'.$iddata.'</form>
			</div>
		';
		$body[] .= $msg;

		break;

	case "mem_edit":
		// メンバー情報修正
		$edit_id = fnc_getpost('edit_id');
		$edit_namae = fnc_getpost('edit_namae');
		$edit_furigana = fnc_getpost('edit_furigana');
		$edit_gender = fnc_getpost('edit_gender');
		$edit_year = fnc_getpost('edit_year');
		$edit_month = fnc_getpost('edit_month');
		$edit_day = fnc_getpost('edit_day');
		$edit_email = fnc_getpost('edit_email');
		$edit_pcode = fnc_getpost('edit_pcode');
		$edit_add1 = fnc_getpost('edit_add1');
		$edit_add2 = fnc_getpost('edit_add2');
		$edit_add3 = fnc_getpost('edit_add3');
		$edit_tel = fnc_getpost('edit_tel');
		$edit_state = fnc_getpost('edit_state');
		$edit_mailsend = fnc_getpost('edit_mailsend');
		$edit_memo = fnc_getpost('edit_memo');
		$edit_kyoten = fnc_getpost('edit_kyoten');
		$edit_orderdate = fnc_getpost('edit_orderdate');
		if ($edit_mailsend == 'on')	{
			$edit_mailsend = '1';
		}else{
			$edit_mailsend = '0';
		}
		$edit_birth	= $edit_year.'/'.$edit_month.'/'.$edit_day;
		$edit_memcard = fnc_getpost('edit_memcard');
		$edit_attchk = fnc_getpost('edit_attchk');
		if ($edit_attchk == 'on')	{
			$edit_attchk = '1';
		}else{
			$edit_attchk = '0';
		}

		try {
			if ($edit_id == '')	{
				// 会員番号採番
				$stt = $db->prepare('SELECT max(id) as maxid FROM memlist');
				$stt->execute();
				$idx = 0;
				$cur_id = 'JW000000';
				while($row = $stt->fetch(PDO::FETCH_ASSOC)){
					$idx++;
					$cur_id = $row['maxid'];
				}
				$cur_num = intval(substr($cur_id,-6)) + 1;
				$edit_id = 'JW'.substr('000000'.strval($cur_num),-6);

				// 新規登録
				$sql  = 'INSERT INTO memlist (';
				$sql .= ' id, email, namae, furigana, gender, birth, pcode, add1, add2, add3, tel, state, mailsend, password, indate, insdate, upddate, memo, memcard, orderdate, attchk ';
				$sql .= ') VALUES (';
				$sql .= ' :id, :email, :namae, :furigana, :gender, :birth, :pcode, :add1, :add2, :add3, :tel, :state, :mailsend, :password, :indate, :insdate, :upddate, :memo, :memcard, :orderdate, :attchk ';
				$sql .= ')';
				$stt2 = $db->prepare($sql);
				$stt2->bindValue(':id'		, $edit_id);
				$stt2->bindValue(':email'	, $edit_email);
				$stt2->bindValue(':namae'	, $edit_namae);
				$stt2->bindValue(':furigana', $edit_furigana);
				$stt2->bindValue(':gender'	, $edit_gender);
				$stt2->bindValue(':birth'	, $edit_birth);
				$stt2->bindValue(':pcode'	, $edit_pcode);
				$stt2->bindValue(':add1'	, $edit_add1);
				$stt2->bindValue(':add2'	, $edit_add2);
				$stt2->bindValue(':add3'	, $edit_add3);
				$stt2->bindValue(':tel'		, $edit_tel);
				$stt2->bindValue(':state'	, $edit_state);
				$stt2->bindValue(':mailsend', $edit_mailsend);
				$stt2->bindValue(':password', md5(getRandomString(10)));
				$stt2->bindValue(':indate'	, date('Y/m/d'));
				$stt2->bindValue(':insdate'	, date('Y/m/d H:i:s'));
				$stt2->bindValue(':upddate'	, date('Y/m/d H:i:s'));
				$stt2->bindValue(':memo'	, $edit_memo);
				$stt2->bindValue(':memcard'	, $edit_memcard);
				$stt2->bindValue(':orderdate'	, $edit_orderdate);
				$stt2->bindValue(':attchk'	, $edit_attchk);
				$stt2->bindValue(':kyoten'	, $edit_kyoten);
				$stt2->execute();
				$arr = array(
					array(
					"result" => "OK",
					"msg"  => "登録しました"
					)
				);
			}else{
				// 既存更新
				$sql  = 'UPDATE memlist SET ';
				$sql .= '  email = "'.$edit_email.'"';
				$sql .= ', namae = "'.$edit_namae.'"';
				$sql .= ', furigana = "'.$edit_furigana.'"';
				$sql .= ', gender = "'.$edit_gender.'"';
				$sql .= ', birth = "'.$edit_birth.'"';
				$sql .= ', pcode = "'.$edit_pcode.'"';
				$sql .= ', add1 = "'.$edit_add1.'"';
				$sql .= ', add2 = "'.$edit_add2.'"';
				$sql .= ', add3 = "'.$edit_add3.'"';
				$sql .= ', tel = "'.$edit_tel.'"';
				$sql .= ', state = "'.$edit_state.'"';
				$sql .= ', mailsend = "'.$edit_mailsend.'"';
				$sql .= ', memo = "'.$edit_memo.'"';
				$sql .= ', kyoten = "'.$edit_kyoten.'"';
				$sql .= ', memcard = "'.$edit_memcard.'"';
				$sql .= ', upddate = "'.date('Y/m/d H:i:s').'"';
				if ($edit_orderdate == '')	{
					$sql .= ', orderdate = NULL';
				}else{
					$sql .= ', orderdate = "'.$edit_orderdate.'"';
				}
				$sql .= ', attchk = '.$edit_attchk;
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

		$msg = json_encode($arr);
		$body[] .= $msg;

		break;

	case "mem_state":
		// 状態変更（表示）
		$state = fnc_getpost('state');
		$msg = fnc_state($state);
		$body[] .= $msg;

		break;

	case "mem_sendmail":
		// 確認メール送信
		$email = fnc_getpost('email');

		// 確認メールを送信
		$subject = "メールアドレスの確認です";
		$mail  = '';
		$mail .= '日本ワーキングホリデー協会です。';
		$mail .= chr(10);
		$mail .= chr(10);
		$mail .= 'メールアドレスの確認の為、このメールをお送りしております。';
		$mail .= chr(10);
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

	case "mem_ser":
		// メンバー検索

		$ser_namae = fnc_getpost('ser_namae');
		$ser_tel = fnc_getpost('ser_tel');
		$ser_email = fnc_getpost('ser_email');
		$ser_id = fnc_getpost('ser_id');
		$ser_stat0 = fnc_getpost('stat0');
		$ser_stat1 = fnc_getpost('stat1');
		$ser_stat5 = fnc_getpost('stat5');
		$ser_stat9 = fnc_getpost('stat9');
		$ser_statA = fnc_getpost('statA');
		$ser_hiduke = fnc_getpost('ser_hiduke');
		$ser_hiduketo = fnc_getpost('ser_hiduketo');
		$ser_memo = fnc_getpost('ser_memo');
		$ser_memcard = fnc_getpost('ser_memcard');

		$body_title[] .= 'メンバー検索結果';
		$msg = '';
		$cond = ' 1=1 ';

		$ser_namae = mb_eregi_replace(' ','',$ser_namae);
		$ser_namae = mb_eregi_replace('　','',$ser_namae);
		$tmp = '';
		for ($idx=0; $idx<mb_strlen($ser_namae); $idx++)	{
			$tmp .= mb_substr($ser_namae,$idx,1).'%';
		}
		if ($ser_namae <> '')	{
			$ser_namae = '%'.$tmp;
		}

		$cond_msg = '[検索条件] ';
		if ($ser_id <> '')	{
			$cond .= ' and id like "%'.$ser_id.'%"';
		}
		if ($ser_namae <> '')	{
			$cond .= ' and ( namae like "%'.$ser_namae.'%" or furigana like "%'.$ser_namae.'%" ) ';
		}
		if ($ser_email <> '')	{
			$cond .= ' and email like "%'.$ser_email.'%"';
		}
		if ($ser_tel <> '')	{
			$cond .= ' and tel like "%'.$ser_tel.'%"';
		}
		if ($ser_memo <> '')	{
			$cond .= ' and memo like "%'.$ser_memo.'%"';
		}
		if ($ser_stat0 == '' && $ser_stat1 == '' && $ser_stat5 == '' && $ser_stat9 == '')	{
			$cond .= '';
		}else{
			$cond .= ' and ( 1=0 ';
			if ($ser_stat0 <> '')	{
				$cond .= ' or state = "0" ';
			}
			if ($ser_stat1 <> '')	{
				$cond .= ' or state = "1" ';
			}
			if ($ser_stat5 <> '')	{
				$cond .= ' or state = "5" ';
			}
			if ($ser_stat9 <> '')	{
				$cond .= ' or state = "9" ';
			}
			$cond .= ' ) ';
		}
		if ($ser_statA <> '')	{
			$cond .= ' and ( orderid is not null or orderdate is not null )';
		}
		if ($ser_hiduke <> '')	{
			$cond .= ' and indate >= "'.$ser_hiduke.'"';
		}
		if ($ser_hiduketo <> '')	{
			$cond .= ' and indate <= "'.$ser_hiduketo.'"';
		}
		if ($ser_memcard <> '')	{
			if ($ser_memcard == '未発行')	{
				$cond .= ' and ( memcard is null or memcard  = "'.$ser_memcard.'" ) ';
			}else{
				$cond .= ' and ( memcard  = "'.$ser_memcard.'" ) ';
			}
		}

		$msg .= '<table class="listdata" style="font-size:10pt;">';
		$msg .= '<tr>';
		$msg .= '<th><input type="checkbox" onclick="fncallcheck(this);"></th>';
		$msg .= '<th>編集</th>';
		$msg .= '<th width="70">会員番号</th>';
		$msg .= '<th width="120">名前</th>';
		$msg .= '<th width="140">フリガナ</th>';
		$msg .= '<th>状態</th>';
		$msg .= '<th>経路</th>';
		$msg .= '<th>CRM-ID</th>';
		$msg .= '<th>カード</th>';
		$msg .= '<th>注意</th>';
		$msg .= '</tr>';
		$msg .= '';

		try {
			$stt = $db->prepare('SELECT id, namae, furigana, state, crmid, mailcheck, memcard, kyoten, attchk FROM memlist WHERE '.$cond.' ORDER BY id');
			$stt->execute();
			$idx = 0;
			while($row = $stt->fetch(PDO::FETCH_ASSOC)){
				$idx++;
				$cur_id = $row['id'];
				$cur_namae = $row['namae'];
				$cur_furigana = $row['furigana'];
				$cur_state = $row['state'];
				$cur_memcard = $row['memcard'];
				if ($cur_memcard == '')	{
					$cur_memcard = '未発行';
				}
				$cur_crmid = $row['crmid'];
				$cur_mailcheck = $row['mailcheck'];
				$cur_kyoten = $row['kyoten'];
				$cur_attchk = $row['attchk'];

				if ($idx % 2 == 0)	{
					$msg .= '<tr>';
				}else{
					$msg .= '<tr class="odd">';
				}
				$msg .= '<td><input type="checkbox" id="check_'.$cur_id.'" ap="'.$cur_id.'" class="selchk" onclick=""></td>';
				$msg .= '<td><input type=button class="button_save" value=" 修正" onclick="fncmemShow(\''.$cur_id.'\');"> </td>';
				$msg .= '<td>'.$cur_id.'</td>';
				$msg .= '<td>'.$cur_namae.'</td>';
				$msg .= '<td>'.$cur_furigana.'</td>';
				$msg .= '<td>'.fnc_state($cur_state).'</td>';
				if ($cur_mailcheck == '00000' || $cur_kyoten <> '')	{
					$msg .= '<td style="text-align:center; background:navy; color:white; font-size:9pt">店頭</td>';
				}else{
					$msg .= '<td style="text-align:center; background:orange; color:white; font-size:9pt">WEB</td>';
				}
				$msg .= '<td>'.$cur_crmid.'</td>';
				$msg .= '<td>'.$cur_memcard.'</td>';
				if ($cur_attchk == 1)	{
					$msg .= '<td style="text-align:center; background:red; color:white; font-size:9pt">注</td>';
				}else{
					$msg .= '<td>&nbsp;</td>';
				}

				$msg .= '</td>';
				$msg .= '</tr>';
			}
		} catch (PDOException $e) {
			die($e->getMessage());
		}
		$msg .= '</table>';
		$body[] .= '[該当件数] '.$idx.'件'.$msg;

		break;

	case "mem_csv":
		// メンバーＣＳＶ出力

		$type = fnc_getpost('type');

		$ser_namae = fnc_getpost('ser_namae');
		$ser_tel = fnc_getpost('ser_tel');
		$ser_email = fnc_getpost('ser_email');
		$ser_id = fnc_getpost('ser_id');
		$ser_stat0 = fnc_getpost('stat0');
		$ser_stat1 = fnc_getpost('stat1');
		$ser_stat5 = fnc_getpost('stat5');
		$ser_stat9 = fnc_getpost('stat9');
		$ser_hiduke = fnc_getpost('ser_hiduke');
		$ser_hiduketo = fnc_getpost('ser_hiduketo');
		$ser_memcard = fnc_getpost('ser_memcard');

		$msg = '';
		$cond = ' 1=1 ';

		$ser_namae = mb_eregi_replace(' ','',$ser_namae);
		$ser_namae = mb_eregi_replace('　','',$ser_namae);
		$tmp = '';
		for ($idx=0; $idx<mb_strlen($ser_namae); $idx++)	{
			$tmp .= mb_substr($ser_namae,$idx,1).'%';
		}
		if ($ser_namae <> '')	{
			$ser_namae = '%'.$tmp;
		}

		if ($ser_id <> '')	{
			$cond .= ' and id like "%'.$ser_id.'%"';
		}
		if ($ser_namae <> '')	{
			$cond .= ' and ( namae like "%'.$ser_namae.'%" or furigana like "%'.$ser_namae.'%" ) ';
		}
		if ($ser_email <> '')	{
			$cond .= ' and email like "%'.$ser_email.'%"';
		}
		if ($ser_tel <> '')	{
			$cond .= ' and tel like "%'.$ser_tel.'%"';
		}
		if ($ser_stat0 == '' && $ser_stat1 == '' && $ser_stat5 == '' && $ser_stat9 == '')	{
			$cond .= '';
		}else{
			$cond .= ' and ( 1=0 ';
			if ($ser_stat0 <> '')	{
				$cond .= ' or state = "0" ';
			}
			if ($ser_stat1 <> '')	{
				$cond .= ' or state = "1" ';
			}
			if ($ser_stat5 <> '')	{
				$cond .= ' or state = "5" ';
			}
			if ($ser_stat9 <> '')	{
				$cond .= ' or state = "9" ';
			}
			$cond .= ' ) ';
		}
		if ($ser_hiduke <> '')	{
			$cond .= ' and indate >= "'.$ser_hiduke.'"';
		}
		if ($ser_hiduketo <> '')	{
			$cond .= ' and indate <= "'.$ser_hiduketo.'"';
		}
		if ($ser_memcard <> '')	{
			if ($ser_memcard == '未発行')	{
				$cond .= ' and ( memcard is null or memcard  = "'.$ser_memcard.'" ) ';
			}else{
				$cond .= ' and ( memcard  = "'.$ser_memcard.'" ) ';
			}
		}

		$ini = parse_ini_file('../../../bin/pdo_mail_list.ini', FALSE);

		$msg  = '';
		$msg .= '"会員番号"';
		$msg .= ',"メール"';
		$msg .= ',"名前"';
		$msg .= ',"フリガナ"';
		$msg .= ',"性別"';
		$msg .= ',"誕生日"';
		$msg .= ',"郵便番号"';
		$msg .= ',"住所１"';
		$msg .= ',"住所２"';
		$msg .= ',"住所３"';
		$msg .= ',"住所４"';
		$msg .= ',"職業"';
		$msg .= ',"電話番号"';
		$msg .= ',"希望国"';
		$msg .= ',"語学力"';
		$msg .= ',"渡航目的"';
		$msg .= ',"協会"';
		$msg .= ',"状態"';
		$msg .= ',"登録日"';
		$msg .= ',"経路"';
		$msg .= ',"支払状態"';
		$msg .= ',"支払日"';
		$msg .= ',"ＣＲＭＩＤ"';
		$msg .= ',"メモ"';
		$msg .= ',"発行状態"';
		$msg .= ',"敬称"';
		$msg .= ',"登録拠点"';
		$msg .= ',"支払方法"';
		$msg .= chr(13).chr(10);

		try {
			$stt = $db->prepare('SELECT id ,email ,namae ,furigana ,gender ,date_format(birth,\'%Y/%m/%d\') as dob ,pcode ,add1 ,add2 ,add3 ,add4 ,job ,tel ,country ,gogaku ,purpose ,know ,state ,date_format(indate,\'%Y/%m/%d\') as nyukaidate ,mailcheck ,orderid ,date_format(orderdate,\'%Y/%m/%d\') as carddate ,crmid ,memo ,memcard, kyoten, payment FROM memlist WHERE '.$cond.' ORDER BY id');
			$stt->execute();
			$idx = 0;
			while($row = $stt->fetch(PDO::FETCH_ASSOC)){
				$idx++;
				$cur_id = $row['id'];
				$cur_email = $row['email'];
				$cur_namae = $row['namae'];
				$cur_furigana = $row['furigana'];
				$cur_gender = $row['gender'];
				$cur_dob = $row['dob'];
				$cur_pcode = $row['pcode'];
				$cur_add1 = $row['add1'];
				$cur_add2 = $row['add2'];
				$cur_add3 = $row['add3'];
				$cur_add4 = $row['add4'];
				$cur_job = $row['job'];
				$cur_tel = $row['tel'];
				$cur_country = $row['country'];
				$cur_gogaku = $row['gogaku'];
				$cur_purpose = $row['purpose'];
				$cur_know = $row['know'];
				$cur_state = $row['state'];
				$cur_nyukaidate = $row['nyukaidate'];
				$cur_mailcheck = $row['mailcheck'];
				$cur_orderid = $row['orderid'];
				$cur_carddate = $row['carddate'];
				$cur_crmid = $row['crmid'];
				$cur_memo = $row['memo'];
				$cur_memcard = $row['memcard'];
				$cur_kyoten = $row['kyoten'];
				$cur_payment = $row['payment'];

				$msg .= ''.$cur_id;
				$msg .= ',"'.$cur_email.'"';
				$msg .= ',"'.$cur_namae.'"';
				$msg .= ',"'.$cur_furigana.'"';
				if ($cur_gender == 'm')	{
					$msg .= ',"男性"';
				}else{
					$msg .= ',"女性"';
				}
				$msg .= ','.$cur_dob.'';
				$msg .= ',"'.$cur_pcode.'"';
				$msg .= ',"'.$cur_add1.'"';
				$msg .= ',"'.$cur_add2.'"';
				$msg .= ',"'.$cur_add3.'"';
				$msg .= ',"'.$cur_add4.'"';
				$msg .= ',"'.$cur_job.'"';
				$msg .= ',"'.$cur_tel.'"';
				$msg .= ',"'.$cur_country.'"';
				$msg .= ',"'.$cur_gogaku.'"';
				$msg .= ',"'.$cur_purpose.'"';
				$msg .= ',"'.$cur_know.'"';
				$msg .= ',"'.$cur_state.':';
				switch ($cur_state)	{
					case '0':
						$msg .= '仮登録';
						break;
					case '1':
						$msg .= 'メアド承認';
						break;
					case '5':
						$msg .= '通常';
						break;
					case '9':
						$msg .= '期限切れ';
						break;
					default:
						$msg .= '不明';
						break;
				}
				$msg .= '"';
				$msg .= ','.$cur_nyukaidate.'';
				if ($cur_mailcheck == '00000' || $cur_kyoten <> '')	{
					$msg .= ',"オフィス"';
				}else{
					$msg .= ',"ＷＥＢ"';
				}
				$msg .= ',"'.$cur_orderid.'"';
				$msg .= ','.$cur_carddate.'';
				$msg .= ',"'.$cur_crmid.'"';
				$msg .= ',"'.$cur_memo.'"';
				if ($cur_memcard == '')	{
					$cur_memcard = '未発行';
				}
				$msg .= ',"'.$cur_memcard.'"';
				$msg .= ',"様"';
				$msg .= ','.$cur_kyoten;
				$msg .= ','.$cur_payment;

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

	case "mem_yamato":
		// クロネコヤマトＣＳＶ出力

		$type = fnc_getpost('type');

		$ser_namae = fnc_getpost('ser_namae');
		$ser_tel = fnc_getpost('ser_tel');
		$ser_email = fnc_getpost('ser_email');
		$ser_id = fnc_getpost('ser_id');
		$ser_stat0 = fnc_getpost('stat0');
		$ser_stat1 = fnc_getpost('stat1');
		$ser_stat5 = fnc_getpost('stat5');
		$ser_stat9 = fnc_getpost('stat9');
		$ser_hiduke = fnc_getpost('ser_hiduke');
		$ser_hiduketo = fnc_getpost('ser_hiduketo');
		$ser_memcard = fnc_getpost('ser_memcard');

		$msg = '';
		$cond = ' 1=1 ';

		$tmp = '';
		$ser_namae = mb_eregi_replace(' ','',$ser_namae);
		$ser_namae = mb_eregi_replace('　','',$ser_namae);
		for ($idx=0; $idx<mb_strlen($ser_namae); $idx++)	{
			$tmp .= mb_substr($ser_namae,$idx,1).'%';
		}
		if ($ser_namae <> '')	{
			$ser_namae = '%'.$tmp;
		}

		if ($ser_id <> '')	{
			$cond .= ' and id like "%'.$ser_id.'%"';
		}
		if ($ser_namae <> '')	{
			$cond .= ' and ( namae like "%'.$ser_namae.'%" or furigana like "%'.$ser_namae.'%" ) ';
		}
		if ($ser_email <> '')	{
			$cond .= ' and email like "%'.$ser_email.'%"';
		}
		if ($ser_tel <> '')	{
			$cond .= ' and tel like "%'.$ser_tel.'%"';
		}
		if ($ser_stat0 == '' && $ser_stat1 == '' && $ser_stat5 == '' && $ser_stat9 == '')	{
			$cond .= '';
		}else{
			$cond .= ' and ( 1=0 ';
			if ($ser_stat0 <> '')	{
				$cond .= ' or state = "0" ';
			}
			if ($ser_stat1 <> '')	{
				$cond .= ' or state = "1" ';
			}
			if ($ser_stat5 <> '')	{
				$cond .= ' or state = "5" ';
			}
			if ($ser_stat9 <> '')	{
				$cond .= ' or state = "9" ';
			}
			$cond .= ' ) ';
		}
		if ($ser_hiduke <> '')	{
			$cond .= ' and indate >= "'.$ser_hiduke.'"';
		}
		if ($ser_hiduketo <> '')	{
			$cond .= ' and indate <= "'.$ser_hiduketo.'"';
		}
		if ($ser_memcard <> '')	{
			if ($ser_memcard == '未発行')	{
				$cond .= ' and ( memcard is null or memcard  = "'.$ser_memcard.'" ) ';
			}else{
				$cond .= ' and ( memcard  = "'.$ser_memcard.'" ) ';
			}
		}

		$ini = parse_ini_file('../../../bin/pdo_mail_list.ini', FALSE);

		$msg  = '';
		$msg .= '"お客様管理番号"';
		$msg .= ',"送り状種類"';
		$msg .= ',"クール区分"';
		$msg .= ',"伝票番号"';
		$msg .= ',"出荷予定日"';
		$msg .= ',"お届け予定日"';
		$msg .= ',"配達時間帯"';
		$msg .= ',"お届け先コード"';
		$msg .= ',"お届け先電話番号"';
		$msg .= ',"お届け先電話番号枝番"';
		$msg .= ',"お届け先郵便番号"';
		$msg .= ',"お届け先住所"';
		$msg .= ',"お届け先アパートマンション名"';
		$msg .= ',"お届け先会社・部門１"';
		$msg .= ',"お届け先会社・部門２"';
		$msg .= ',"お届け先名"';
		$msg .= ',"お届け先名仮名"';
		$msg .= ',"敬称"';
		$msg .= ',"ご依頼主コード"';
		$msg .= ',"ご依頼主電話番号"';
		$msg .= ',"ご依頼主電話番号枝番"';
		$msg .= ',"ご依頼主郵便番号"';
		$msg .= ',"ご依頼主住所"';
		$msg .= ',"ご依頼主アパートマンション"';
		$msg .= ',"ご依頼主名"';
		$msg .= ',"ご依頼主名仮名"';
		$msg .= ',"品名コード１"';
		$msg .= ',"品名１"';
		$msg .= ',"品名コード２"';
		$msg .= ',"品名２"';
		$msg .= ',"荷扱い１"';
		$msg .= ',"荷扱い２"';
		$msg .= ',"記事"';
		$msg .= ',"ｺﾚｸﾄ代金引換額"';
		$msg .= ',"内消費税額等"';
		$msg .= ',"止置き"';
		$msg .= ',"営業所コード"';
		$msg .= ',"発行枚数"';
		$msg .= ',"個数口表示フラグ"';
		$msg .= ',"請求先顧客コード"';
		$msg .= ',"請求先分類コード"';
		$msg .= ',"運賃管理番号"';
		$msg .= ',"注文時カード払いデータ登録"';
		$msg .= ',"注文時カード払い加盟店番号"';
		$msg .= ',"注文時カード払い申込受付番号１"';
		$msg .= ',"注文時カード払い申込受付番号２"';
		$msg .= ',"注文時カード払い申込受付番号３"';
		$msg .= ',"お届け予定ｅメール利用区分"';
		$msg .= ',"お届け予定ｅメールe-mailアドレス"';
		$msg .= ',"入力機種"';
		$msg .= ',"お届け予定ｅメールメッセージ"';
		$msg .= ',"お届け完了ｅメール利用区分"';
		$msg .= ',"お届け完了ｅメールe-mailアドレス"';
		$msg .= ',"お届け完了ｅメールメッセージ"';
		$msg .= ',"予備"';
		$msg .= ',"予備"';
		$msg .= ',"予備"';
		$msg .= ',"予備"';
		$msg .= ',"予備"';
		$msg .= ',"予備"';
		$msg .= ',"予備"';
		$msg .= ',"予備"';
		$msg .= ',"予備"';
		$msg .= ',"予備"';
		$msg .= ',"予備"';
		$msg .= ',"予備"';
		$msg .= ',"予備"';
		$msg .= ',"予備"';
		$msg .= ',"予備"';
		$msg .= ',"予備"';
		$msg .= ',"予備"';
		$msg .= ',"予備"';
		$msg .= ',"予備"';
		$msg .= ',"複数口くくりキー"';
		$msg .= ',"検索キータイトル1"';
		$msg .= ',"検索キー1"';
		$msg .= ',"検索キータイトル2"';
		$msg .= ',"検索キー2"';
		$msg .= ',"検索キータイトル3"';
		$msg .= ',"検索キー3"';
		$msg .= ',"検索キータイトル4"';
		$msg .= ',"検索キー4"';
		$msg .= ',"検索キータイトル5"';
		$msg .= ',"検索キー5"';
		$msg .= ',"発行依頼先会社コード"';
		$msg .= ',"発行依頼先分類コード"';
		$msg .= chr(13).chr(10);

		try {
			$stt = $db->prepare('SELECT id ,email ,namae ,furigana ,gender ,date_format(birth,\'%Y/%m/%d\') as dob ,pcode ,add1 ,add2 ,add3 ,add4 ,job ,tel ,country ,gogaku ,purpose ,know ,state ,date_format(indate,\'%Y/%m/%d\') as nyukaidate ,mailcheck ,orderid ,date_format(orderdate,\'%Y/%m/%d\') as carddate ,crmid ,memo ,memcard, kyoten, payment FROM memlist WHERE '.$cond.' ORDER BY id');
			$stt->execute();
			$idx = 0;
			while($row = $stt->fetch(PDO::FETCH_ASSOC)){
				$idx++;
				$cur_id = $row['id'];
				$cur_email = $row['email'];
				$cur_namae = $row['namae'];
				$cur_furigana = $row['furigana'];
				$cur_gender = $row['gender'];
				$cur_dob = $row['dob'];
				$cur_pcode = $row['pcode'];
				$cur_add1 = $row['add1'];
				$cur_add2 = $row['add2'];
				$cur_add3 = $row['add3'];
				$cur_add4 = $row['add4'];
				$cur_job = $row['job'];
				$cur_tel = $row['tel'];
				$cur_country = $row['country'];
				$cur_gogaku = $row['gogaku'];
				$cur_purpose = $row['purpose'];
				$cur_know = $row['know'];
				$cur_state = $row['state'];
				$cur_nyukaidate = $row['nyukaidate'];
				$cur_mailcheck = $row['mailcheck'];
				$cur_orderid = $row['orderid'];
				$cur_carddate = $row['carddate'];
				$cur_crmid = $row['crmid'];
				$cur_memo = $row['memo'];
				$cur_memcard = $row['memcard'];
				$cur_kyoten = $row['kyoten'];
				$cur_payment = $row['payment'];

				$msg .= '"'.$cur_id.'"';
				$msg .= ',"3"';
				$msg .= ',""';
				$msg .= ',""';
				$msg .= ',"'.date('Y/m/d').'"';
				$msg .= ',""';
				$msg .= ',""';
				$msg .= ',""';
				$msg .= ',"'.$cur_tel.'"';
				$msg .= ',""';
				$msg .= ',"'.$cur_pcode.'"';
				$msg .= ',"'.$cur_add1.$cur_add2.$cur_add3.'"';
				$msg .= ',"'.$cur_add4.'"';
				$msg .= ',""';
				$msg .= ',"'.$cur_id.'"';
				$msg .= ',"'.$cur_namae.'"';
				$msg .= ',""';
				$msg .= ',"様"';
				$msg .= ',""';
				$msg .= ',"0363045858"';
				$msg .= ',""';
				$msg .= ',"1600023"';
				$msg .= ',"東京都新宿区西新宿１－３－３"';
				$msg .= ',"品川ステーションビル５階"';
				$msg .= ',"日本ワーキングホリデー協会"';
				$msg .= ',""';
				$msg .= ',""';
				$msg .= ',会員証';
				$msg .= ',""';
				$msg .= ',""';
				$msg .= ',""';
				$msg .= ',""';
				$msg .= ',""';
				$msg .= ',""';
				$msg .= ',""';
				$msg .= ',""';
				$msg .= ',""';
				$msg .= ',""';
				$msg .= ',""';
				$msg .= ',""';
				$msg .= ',""';
				$msg .= ',""';
				$msg .= ',""';
				$msg .= ',""';
				$msg .= ',""';
				$msg .= ',""';
				$msg .= ',""';
				$msg .= ',""';
				$msg .= ',""';
				$msg .= ',""';
				$msg .= ',""';
				$msg .= ',""';
				$msg .= ',""';
				$msg .= ',""';
				$msg .= ',""';
				$msg .= ',""';
				$msg .= ',""';
				$msg .= ',""';
				$msg .= ',""';
				$msg .= ',""';
				$msg .= ',""';
				$msg .= ',""';
				$msg .= ',""';
				$msg .= ',""';
				$msg .= ',""';
				$msg .= ',""';
				$msg .= ',""';
				$msg .= ',""';
				$msg .= ',""';
				$msg .= ',""';
				$msg .= ',""';
				$msg .= ',""';
				$msg .= ',""';
				$msg .= ',""';
				$msg .= ',""';
				$msg .= ',""';
				$msg .= ',""';
				$msg .= ',""';
				$msg .= ',""';
				$msg .= ',""';
				$msg .= ',""';
				$msg .= ',""';
				$msg .= ',""';
				$msg .= ',""';
				$msg .= ',""';
				$msg .= ',""';

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

	case "card":
		// メンバーカード発行
		$id = $param[3];
		try {
			$stt = $db->prepare('SELECT id, email, namae, tel, state, indate FROM memlist WHERE id = "'.$id.'"');
			$stt->execute();
			$idx = 0;
			while($row = $stt->fetch(PDO::FETCH_ASSOC)){
				$idx++;
				$cur_id = $row['id'];
				$cur_email = $row['email'];
				$cur_namae = $row['namae'];
				$cur_tel = $row['tel'];
				$cur_state = $row['state'];
				$cur_indate = $row['indate'];
			}
		} catch (PDOException $e) {
			die($e->getMessage());
		}

		require('fpdf/japanese.php');

		$size = array(91,55);
		$pdf=new PDF_Japanese('L','mm',$size);

		$pdf->AddSJISFont();
		$pdf->Open();
		$pdf->AddPage();
		$pdf->SetFont('SJIS','',16);
		$pdf->SetMargins(0,0,0,0);

		$pdf->Image('http://www.jawhm.or.jp/images/memcard.png', 0, 0, 100.0);

		$pdf->Text(51,35,mb_convert_encoding($cur_id, 'SJIS'));
		$pdf->Text(50,42,mb_convert_encoding($cur_namae, 'SJIS'));
		$pdf->SetFont('SJIS','',10);
		$pdf->Text(50,47,mb_convert_encoding('登録  '.str_replace('-','.',$cur_indate), 'SJIS'));

		$pdf->Output();

		$msg  = '';
		$body[] .= $msg;

		break;

	case "card2":
		// 新メンバーカード発行
		$id = $param[3];
		try {
			$stt = $db->prepare('SELECT id, email, namae, tel, state, indate, password FROM memlist WHERE id = "'.$id.'"');
			$stt->execute();
			$idx = 0;
			while($row = $stt->fetch(PDO::FETCH_ASSOC)){
				$idx++;
				$cur_id = $row['id'];
				$cur_email = $row['email'];
				$cur_namae = $row['namae'];
				$cur_tel = $row['tel'];
				$cur_state = $row['state'];
				$cur_indate = $row['indate'];
				$cur_password = $row['password'];
			}
		} catch (PDOException $e) {
			die($e->getMessage());
		}

		require('fpdf/japanese.php');

		$size = array(89,55);
		$pdf=new PDF_Japanese('L','mm',$size);

		$pdf->AddSJISFont();
		$pdf->Open();
		$pdf->AddPage();
		$pdf->SetFont('SJIS','B',12);
		$pdf->SetMargins(0,0,0,0);
		$pdf->SetTextColor(255, 255, 255);

		$pdf->Image('http://www.jawhm.or.jp/images/memcard01.png', 0, 0, 90.0, 56.0);
		$pdf->Image('http://www.jawhm.or.jp/barcode/qr.php?code=http://www.jawhm.or.jp/qr/?id='.$cur_id.'[amp]p='.mb_substr($cur_password,0,6), 63, 4, 20.0, 20.0, 'PNG');

		$pdf->Text(58,38,mb_convert_encoding($cur_id, 'SJIS'));
		$pdf->Text(57,44,mb_convert_encoding($cur_namae, 'SJIS'));
		$pdf->SetFont('SJIS','',5);
		$pdf->Text(63,48,mb_convert_encoding('登録  '.str_replace('-','.',$cur_indate), 'SJIS'));



		$pdf->Output();

		$msg  = '';
		$body[] .= $msg;

		break;

	case "precard":
		// 仮カード発行
		$id = $param[3];
		try {
			$stt = $db->prepare('SELECT id, email, namae, tel, state, orderid, orderdate, indate, payment FROM memlist WHERE id = "'.$id.'"');
			$stt->execute();
			$idx = 0;
			while($row = $stt->fetch(PDO::FETCH_ASSOC)){
				$idx++;
				$cur_id = $row['id'];
				$cur_email = $row['email'];
				$cur_namae = $row['namae'];
				$cur_tel = $row['tel'];
				$cur_state = $row['state'];
				$cur_indate = $row['indate'];
				$cur_orderid = $row['orderid'];
				$cur_orderdate = $row['orderdate'];
				$cur_payment = $row['payment'];
			}
		} catch (PDOException $e) {
			die($e->getMessage());
		}

		require('fpdf/japanese.php');

		$size = array(210,297);
		$pdf=new PDF_Japanese('P','mm',$size);

		$pdf->AddSJISFont();
		$pdf->Open();
		$pdf->AddPage();
		$pdf->SetMargins(0,0,0,0);

		$pdf->SetTextColor(0, 0, 139);
		$pdf->SetFont('SJIS','B',28);
		$pdf->Text(161,15,mb_convert_encoding('JAWHM', 'SJIS'));
		$pdf->SetLineWidth(0.8);
		$pdf->SetDrawColor(0, 0, 139);
		$pdf->Line(160, 18, 200, 18);
		$pdf->SetFont('SJIS','',12);
		$pdf->SetTextColor(0, 0, 0);
		$pdf->Text(168,23,mb_convert_encoding(date('Y/m/d'), 'SJIS'));

		$pdf->SetTextColor(0, 0, 0);
		$pdf->SetFont('SJIS','',14);
		$pdf->Text(15,36,mb_convert_encoding($cur_namae.' 様', 'SJIS'));

		$pdf->SetFont('SJIS','',20);
		$pdf->Text(58,51,mb_convert_encoding('【　メンバー登録のお知らせ　】', 'SJIS'));

		$pdf->SetFont('SJIS','',12);
		$pdf->Text(25,70,mb_convert_encoding('以下の通りメンバー登録を受け付けました。', 'SJIS'));
		$pdf->Text(30,80,mb_convert_encoding('会員番号　　　　：　'.$cur_id, 'SJIS'));
		$pdf->Text(30,85,mb_convert_encoding('お名前　　　　　：　'.$cur_namae, 'SJIS'));
		$pdf->Text(30,90,mb_convert_encoding('メールアドレス　：　'.$cur_email, 'SJIS'));

		if ($cur_state == '5')	{
			if ($cur_payment == 'conv')	{
				$cur_payment = 'コンビニ決済';
			}else{
				if ($cur_payment == 'card')	{
					$cur_payment = 'クレジットカード';
				}else{
					$cur_payment = '';
				}
			}
			if ($cur_orderid <> '')			{
				$pdf->Text(25,110,mb_convert_encoding('メンバー登録料を、以下の通りお支払頂きました。', 'SJIS'));
				if ($cur_payment <> '')	{
					$pdf->Text(30,120,mb_convert_encoding('決済方法　　：　'.$cur_payment , 'SJIS'));
				}
				$pdf->Text(30,125,mb_convert_encoding('決済金額　　：　5,000円' , 'SJIS'));
				$pdf->Text(30,130,mb_convert_encoding('決済番号　　：　'.$cur_orderid , 'SJIS'));
				$pdf->Text(30,135,mb_convert_encoding('決済日時　　：　'.$cur_orderdate , 'SJIS'));
			}else{
				$pdf->Text(25,120,mb_convert_encoding('ご登録の住所に本カードを郵送いたしますので、しばらくお待ちください。', 'SJIS'));
			}
		}elseif ($cur_state == '1')	{
			$pdf->Text(25,110,mb_convert_encoding('銀行振込にてメンバー登録料(5,000円)をお支払の場合は、以下にお振込み下さい。', 'SJIS'));
			$pdf->Text(30,120,mb_convert_encoding('銀行名　　：　三井住友銀行 (0009)' , 'SJIS'));
			$pdf->Text(30,125,mb_convert_encoding('支店名　　：　新宿支店 (221)' , 'SJIS'));
			$pdf->Text(30,130,mb_convert_encoding('口座番号　：　普通　4246817' , 'SJIS'));
			$pdf->Text(30,135,mb_convert_encoding('名義人　　：　シャ）ニホンワーキングホリデーキョウカイ' , 'SJIS'));
			$pdf->SetTextColor(255, 0, 0);
			$pdf->Text(35,145,mb_convert_encoding('【ご注意】振込手数料はお客様のご負担となります。', 'SJIS'));
			$pdf->Text(35,150,mb_convert_encoding('　　　　　なお、必ずメンバー登録時のお名前でお振込み下さい。', 'SJIS'));
			$pdf->SetTextColor(0, 0, 0);
		}else{
			$pdf->SetTextColor(255, 0, 0);
			$pdf->SetFont('SJIS','',20);
			$pdf->Text(25,120,mb_convert_encoding('会員情報が確認できません。', 'SJIS'));
			$pdf->Text(25,140,mb_convert_encoding('この書面は無効です。ご注意ください。', 'SJIS'));
			$pdf->SetTextColor(0, 0, 0);
		}

		$pdf->SetTextColor(0, 0, 0);
		$pdf->SetFont('SJIS','',12);
		$pdf->Text(112,170,mb_convert_encoding('一般社団法人　日本ワーキングホリデー協会', 'SJIS'));
		$pdf->Text(139,175,mb_convert_encoding('東京都新宿区西新宿１－３－３', 'SJIS'));
		$pdf->Text(147,180,mb_convert_encoding('品川ステーションビル５階', 'SJIS'));
		$pdf->Text(110,185,mb_convert_encoding('TEL : 03-6304-5858  E-Mail: info@jawhm.or.jp', 'SJIS'));

		if ($cur_state == '5')	{
			$pdf->Text(25,202,mb_convert_encoding('本カードがお手元に届くまでの間は、こちらの仮カードをご利用ください。', 'SJIS'));
		}
		if ($cur_state == '1')	{
			$pdf->Text(25,202,mb_convert_encoding('メンバー登録料のご入金確認後に本カードをお送りいたします。', 'SJIS'));
		}

		$pdf->Image('http://www.jawhm.or.jp/images/memcard.png', 60, 210, 100.0);

		//$pdf->Image('http://www.jawhm.or.jp/image.php', 60, 210, 100.0, 100.0 , 'PNG');

		$pdf->SetFont('SJIS','',16);
		$pdf->Text(120,245,mb_convert_encoding($cur_id, 'SJIS'));
		$pdf->Text(120,252,mb_convert_encoding($cur_namae, 'SJIS'));
		$pdf->SetFont('SJIS','',10);
		$pdf->Text(120,257,mb_convert_encoding('登録  '.str_replace('-','.',$cur_indate), 'SJIS'));
		$pdf->Text(80,268,mb_convert_encoding('This is Temporary Members Card.', 'SJIS'));

		$pdf->SetLineWidth(0.2);
		$pdf->SetDrawColor(0, 0, 0);
		$pdf->Line( 60, 210,   160, 210);
		$pdf->Line( 60, 270.5, 160, 270.5);
		$pdf->Line(160, 210,   160, 270.5);

		$pdf->SetFont('SJIS','',22);
		$pdf->SetTextColor(255, 0, 0);
		$pdf->Text(75,251,mb_convert_encoding('仮カード', 'SJIS'));

		$pdf->Output();

		$msg  = '';
		$body[] .= $msg;

		break;

	case "repwd":
		// パスワードのお知らせ
		$newpwd = getRandomString(10);

		$id = $param[3];
		try {
			$stt = $db->prepare('UPDATE memlist SET password = :password WHERE id = :id ');
			$stt->bindValue(':id', $id);
			$stt->bindValue(':password', md5($newpwd));
			$stt->execute();
			$stt = $db->prepare('SELECT id, email, namae, tel, state, orderid, orderdate, indate FROM memlist WHERE id = "'.$id.'"');
			$stt->execute();
			$idx = 0;
			while($row = $stt->fetch(PDO::FETCH_ASSOC)){
				$idx++;
				$cur_id = $row['id'];
				$cur_email = $row['email'];
				$cur_namae = $row['namae'];
				$cur_tel = $row['tel'];
				$cur_state = $row['state'];
				$cur_indate = $row['indate'];
				$cur_orderid = $row['orderid'];
				$cur_orderdate = $row['orderdate'];
			}
		} catch (PDOException $e) {
			die($e->getMessage());
		}

		require('fpdf/japanese.php');

		$size = array(210,297);
		$pdf=new PDF_Japanese('P','mm',$size);

		$pdf->AddSJISFont();
		$pdf->Open();
		$pdf->AddPage();
		$pdf->SetMargins(0,0,0,0);

		$pdf->SetTextColor(0, 0, 139);
		$pdf->SetFont('SJIS','B',28);
		$pdf->Text(161,15,mb_convert_encoding('JAWHM', 'SJIS'));
		$pdf->SetLineWidth(0.8);
		$pdf->SetDrawColor(0, 0, 139);
		$pdf->Line(160, 18, 200, 18);
		$pdf->SetFont('SJIS','',12);
		$pdf->SetTextColor(0, 0, 0);
		$pdf->Text(168,23,mb_convert_encoding(date('Y/m/d'), 'SJIS'));

		$pdf->SetTextColor(0, 0, 0);
		$pdf->SetFont('SJIS','',14);
		$pdf->Text(15,36,mb_convert_encoding($cur_namae.' 様', 'SJIS'));

		$pdf->SetFont('SJIS','',20);
		$pdf->Text(62,60,mb_convert_encoding('【　パスワードのご案内　】', 'SJIS'));

		$pdf->SetFont('SJIS','',14);
		$pdf->Text(25,90,mb_convert_encoding('以下の通りパスワードを設定しました。', 'SJIS'));
		$pdf->Text(30,105,mb_convert_encoding('会員番号　　　　：　'.$cur_id, 'SJIS'));
		$pdf->Text(30,120,mb_convert_encoding('お名前　　　　　：　'.$cur_namae, 'SJIS'));
		$pdf->Text(30,135,mb_convert_encoding('メールアドレス　：　（セキュリティーの為、表記しません）', 'SJIS'));
		$pdf->Text(30,150,mb_convert_encoding('パスワード　　　：　'.$newpwd, 'SJIS'));
		$pdf->Text(75,160,mb_convert_encoding('（パスワードは英数の組み合わせで１０桁です）', 'SJIS'));

		$pdf->Text(25,190,mb_convert_encoding('なお、メンバー専用ページは以下ＵＲＬからログインして頂けます。', 'SJIS'));
		$pdf->SetFont('SJIS','',16);
		$pdf->Text(60,205,mb_convert_encoding('http://www.jawhm.or.jp/member', 'SJIS'));

		$pdf->SetTextColor(0, 0, 0);
		$pdf->SetFont('SJIS','',12);
		$pdf->Text(112,240,mb_convert_encoding('一般社団法人　日本ワーキングホリデー協会', 'SJIS'));
		$pdf->Text(139,248,mb_convert_encoding('東京都新宿区西新宿１－３－３', 'SJIS'));
		$pdf->Text(147,256,mb_convert_encoding('品川ステーションビル５階', 'SJIS'));
		$pdf->Text(110,264,mb_convert_encoding('TEL : 03-6304-5858  E-Mail: info@jawhm.or.jp', 'SJIS'));

		$pdf->Output();

		$msg  = '';
		$body[] .= $msg;

		break;

	case "show_quest":
		// 登録時アンケート表示
		$edit_id = fnc_getpost('id');

		try {
			$stt = $db->prepare('SELECT id, country, gogaku, purpose, know FROM memlist WHERE id = "'.$edit_id.'"');
			$stt->execute();
			$idx = 0;
			while($row = $stt->fetch(PDO::FETCH_ASSOC)){
				$idx++;
				$cur_id = $row['id'];
				$cur_country = $row['country'];
				$cur_gogaku = $row['gogaku'];
				$cur_purpose = $row['purpose'];
				$cur_know = $row['know'];
			}
		} catch (PDOException $e) {
			die($e->getMessage());
		}

		$msg  = '';
		$msg .= '<table border="1">';
		$msg .= '<tr>';
		$msg .= '<td>興味国</td><td>'.$cur_country.'</td>';
		$msg .= '</tr><tr>';
		$msg .= '<td>語学力</td><td>'.$cur_gogaku.'</td>';
		$msg .= '</tr><tr>';
		$msg .= '<td>目的</td><td>'.$cur_purpose.'</td>';
		$msg .= '</tr><tr>';
		$msg .= '<td>協会</td><td>'.$cur_know.'</td>';
		$msg .= '</tr></table>';
		$msg .= '';

		$body[] .= $msg;

		break;

	case "mem_cardsend":
		// 発送手配
		$edit_ids = fnc_getpost('id');

		$arr_id = explode(',' , $edit_ids);

		$err_msg = '';
		$tbl_msg = '';

		try {
			$no  = 0;
			$idx = 0;
			while ($idx<count($arr_id))	{
				$stt = $db->prepare('SELECT id, namae, crmid, memcard, state FROM memlist WHERE id = "'.$arr_id[$idx].'"');
				$stt->execute();
				while($row = $stt->fetch(PDO::FETCH_ASSOC)){
					$cur_id = $row['id'];
					$cur_namae = $row['namae'];
					$cur_crmid = $row['crmid'];
					$cur_memcard = $row['memcard'];
					$cur_state = $row['state'];
				}
				$dataerr = 0;
				if ($cur_crmid == '')	{
					$err_msg .= '<tr><td>'.$cur_id.'</td><td>'.$cur_namae.'</td><td>ＣＲＭ未転送</td></tr>';
					$dataerr++;
				}
				if ($cur_memcard <> '未発行' && $cur_memcard <> '')	{
					$err_msg .= '<tr><td>'.$cur_id.'</td><td>'.$cur_namae.'</td><td>カード発行状態エラー</td></tr>';
					$dataerr++;
				}
				if ($cur_state <> '5')	{
					$err_msg .= '<tr><td>'.$cur_id.'</td><td>'.$cur_namae.'</td><td>登録状態エラー</td></tr>';
					$dataerr++;
				}
				if ($dataerr == 0)	{
					$no++;
					$tbl_msg .= '<tr>';
					$tbl_msg .= '<td>&nbsp;'.$cur_id.'&nbsp;</td>';
					$tbl_msg .= '<td>&nbsp;'.$cur_namae.'&nbsp;</td>';
					$tbl_msg .= '<td>';
					$tbl_msg .= '<input type="text" size="30" name="send_'.$no.'" onfocus="fncgetfocus(this);" onblur="fnclostfocus(this);" style="ime-mode:inactive;">';
					$tbl_msg .= '<input type="hidden" name="id_'.$no.'" value="'.$cur_id.'">';
					$tbl_msg .= '<input type="hidden" name="crmid_'.$no.'" value="'.$cur_crmid.'">';
					$tbl_msg .= '</td>';
					$tbl_msg .= '<td>&nbsp;'.$cur_crmid.'&nbsp;</td>';
					$tbl_msg .= '</tr>';
				}

				$idx++;
			}

		} catch (PDOException $e) {
			die($e->getMessage());
		}
		$tbl_msg .= '<input type="hidden" name="linecnt" value="'.$no.'">';

		$msg  = '';
		$msg .= '
				<div id="div_card_edit" style="display:none; margin:10px 20px 10px 20px; font-size:10pt; cursor:default;">
					<div style="margin:0 0 10px 0; font-size:12pt; font-weight:bodl;">【メンバーカード発送手配】</div>
					<div style="width:520px; height:340px; overflow: scroll;">';
		if ($err_msg <> '')	{
			$msg .= '<span style="font-size:14pt; font-weight:bold;">エラーがあります!!</span><br/>';
			$msg .= '<table border="1" bgcolor="red" style="margin:5px 0 15px 0;">'.$err_msg.'</table>';
		}
		$msg .= '		<form id="form_card_edit">
						<table border="1">
							<tr>
								<th>会員番号</th>
								<th>名前</th>
								<th>発送番号</th>
								<th>CRM-ID</th>
							</tr>
		';

		$msg .= $tbl_msg;
		$msg .= '
				</table>
			</form>
		</div>
				<div style="text-align:right; width:500px; margin-top:10px;">
					<input type=button class="button_cancel" value="やめる" onclick="fncHide();">&nbsp;&nbsp;
					<input type=button class="button_submit" value="登録" onclick="fnccardpost(\'form_card_edit\');">
				</div>
			</div>
		</div>
		';

		$body[] .= $msg;

		break;

	case "mem_cardsend_set":
		// 発送手配手続き
		$edit_cnt = fnc_getpost('linecnt');
		$idx = 1;
		$edit_id = array();
		$edit_crmid = array();
		$edit_send = array();
		while($idx<=$edit_cnt)	{
			$edit_id[$idx] = fnc_getpost('id_'.$idx);
			$edit_crmid[$idx] = fnc_getpost('crmid_'.$idx);
			$edit_send[$idx] = fnc_getpost('send_'.$idx);
			$idx++;
		}

		$msg = '';

		try {
			$idx = 1;
			while($idx<=count($edit_id))	{
				// 既存更新
				$sql  = 'UPDATE memlist SET ';
				$sql .= '  memcard = "発送済み"';
				$sql .= ', upddate = "'.date('Y/m/d H:i:s').'"';
				$sql .= ' WHERE id = "'.$edit_id[$idx].'"';
				$stt = $db->prepare($sql);
				$stt->execute();

				// 	履歴設定
				$data = array(
						 'pwd' => '303pittST'
						,'act' => 'rireki'
						,'edit_customid' => $edit_crmid[$idx]
						,'edit_msg' => '【会員カード発送】　'.date('Y/m/d').'　伝票: '.$edit_send[$idx]
						);
				$url = 'https://toratoracrm.com/crm/';
				$val = wbsRequest($url, $data);
				$ret = json_decode($val, true);
				if ($ret['result'] == 'OK')	{
					// OK
				}


				$idx++;
			}

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


	case "send_crm":
		// ＣＲＭ転送
		$edit_id = fnc_getpost('id');
		$edit_sbt = fnc_getpost('sbt');

		try {
			$stt = $db->prepare('SELECT id, email, namae, furigana, gender, birth, year(birth) as yy, month(birth) as mm, day(birth) as dd, pcode, add1, add2, add3, tel, state, indate, mailsend, orderid, orderdate, crmid, crmdate, job, country, gogaku, purpose, know FROM memlist WHERE id = "'.$edit_id.'"');
			$stt->execute();
			$idx = 0;
			while($row = $stt->fetch(PDO::FETCH_ASSOC)){
				$idx++;
				$cur_id = $row['id'];
				$cur_email = $row['email'];
				$cur_namae = $row['namae'];
				$cur_furigana = $row['furigana'];
				$cur_gender = $row['gender'];
				$cur_birth = $row['birth'];
				$cur_pcode = $row['pcode'];
				$cur_add1 = $row['add1'];
				$cur_add2 = $row['add2'];
				$cur_add3 = $row['add3'];
				$cur_tel = $row['tel'];
				$cur_mailsend = $row['mailsend'];
				$cur_state = $row['state'];
				$cur_indate = $row['indate'];
				$cur_orderid = $row['orderid'];
				$cur_orderdate = $row['orderdate'];
				$cur_crmid = $row['crmid'];
				$cur_crmdate = $row['crmdate'];
				$cur_job = $row['job'];
				$cur_country = $row['country'];
				$cur_gogaku = $row['gogaku'];
				$cur_purpose = $row['purpose'];
				$cur_know = $row['know'];
			}
		} catch (PDOException $e) {
			die($e->getMessage());
		}

		// ＣＲＭに転送
		$data = array(
				 'pwd' => '303pittST'
				,'act' => 'member'
				,'edit_id' => $cur_id
				,'edit_sbt' => $edit_sbt
				,'edit_email' => $cur_email
				,'edit_namae' => $cur_namae
				,'edit_furigana' => $cur_furigana
				,'edit_gender' => $cur_gender
				,'edit_birth' => $cur_birth
				,'edit_pcode' => $cur_pcode
				,'edit_add1' => $cur_add1
				,'edit_add2' => $cur_add2
				,'edit_add3' => $cur_add3
				,'edit_tel' => $cur_tel
				,'edit_job' => $cur_job
				,'edit_country' => $cur_country
				,'edit_gogaku' => $cur_gogaku
				,'edit_purpose' => $cur_purpose
				,'edit_know' => $cur_know
				,'edit_indate' => $cur_indate
				,'edit_orderid' => $cur_orderid
				,'edit_kyoten' => $edit_sbt
				);

		$url = 'https://toratoracrm.com/crm/';
		$val = wbsRequest($url, $data);
		$ret = json_decode($val, true);

		$customid = '';
		if ($ret['result'] == 'OK')	{
			// OK
			$customid = $ret['customid'];
		}

		// 会員情報更新
		try {
			$sql  = 'UPDATE memlist SET ';
			$sql .= '  crmid = "'.$customid.'"';
			$sql .= ', crmdate = "'.date('Y/m/d H:i:s').'"';
			$sql .= ' WHERE id = "'.$cur_id.'"';
			$stt = $db->prepare($sql);
			$stt->execute();
		} catch (PDOException $e) {
			die($e->getMessage());
		}

		// メーリングリスト追加
		if ($cur_email <> '' && $cur_mailsend == '1' )	{
			try {
				$stt = $db->prepare('SELECT vmail FROM maillist WHERE vmail = "'.$cur_email.'"');
				$stt->execute();
				$idx = 0;
				while($row = $stt->fetch(PDO::FETCH_ASSOC)){
					$idx++;
					$vmail = $row['vmail'];
				}
			} catch (PDOException $e) {
				die($e->getMessage());
			}

			try {

				// JW削除
				$sql  = 'DELETE FROM maillist ';
				$sql .= ' WHERE vmail = "'.$cur_email.'"';
				$sql .= ' AND vtype = "jw"';
				$stt = $db->prepare($sql);
				$stt->execute();

				// 新規登録
				$sql  = 'INSERT INTO maillist (';
				$sql .= ' vtype, vmail, vname1, vname2, cdate, udate, vsend, vstat, vcheck, vid ';
				$sql .= ') VALUES (';
				$sql .= ' :vtype, :vmail, :vname1, :vname2, :cdate, :udate, :vsend, :vstat, :vcheck, :vid ';
				$sql .= ')';
				$stt2 = $db->prepare($sql);
				$stt2->bindValue(':vtype'	, 'jw');
				$stt2->bindValue(':vmail'	, $cur_email);
				$stt2->bindValue(':vname1'	, $cur_namae);
				$stt2->bindValue(':vname2'	, $cur_id);
				$stt2->bindValue(':cdate'	, date('Y/m/d'));
				$stt2->bindValue(':udate'	, date('Y/m/d'));
				$stt2->bindValue(':vsend'	, '1');
				$stt2->bindValue(':vstat'	, '登録');
				$stt2->bindValue(':vcheck'	, getRandomString(14));
				$stt2->bindValue(':vid'		, $customid);
				$stt2->execute();
			} catch (PDOException $e) {
				die($e->getMessage());
			}
		}

		$msg  = '';
		$msg .= '転送しました 【'.$customid.'】';
		$body[] .= $msg;

}


?>