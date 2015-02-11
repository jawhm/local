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
	case "list":
		// イベント管理
		$e = fnc_getpost('e');

		// イベント操作系ＪＳ
		$script .= '
			// グローバル変数
			$goforuse = 0;

			// カレンダー表示
			InputCalendar.createOnLoaded(\'ser_hiduke\', {lang:\'ja\'});
			InputCalendar.createOnLoaded(\'ser_hiduketo\', {lang:\'ja\'});

			// イベント検索
			function fncSereventList()	{
				jQuery("#processing").show();
				jQuery.ajax({
					type: "POST",
					url: "'.$url_base.'data/event2/event_ser",
					data: jQuery("#form_event_list").serialize(),
					success: function(msg){
						jQuery("#processing").hide();
						jQuery("#res_event_list").html(msg);
					},
					error:function(){
						jQuery("#processing").hide();
						alert("通信エラーが発生しました。");
					}
				});
			}

			// 予約者リスト出力
			function fncYoyakuListCsv(hiduke, place)	{
				if(confirm(place + \'会場、\' + hiduke + \'分の予約者リストを出力します。よろしいですか？\')){
					jQuery("#processing").show();
					window.open(\''.$url_base.'csv/yoyaku/yoyakulist_csv/?type=out&seminardate=\' + hiduke + \'&seminarplace=\' + place, \'_blank\', \'width=200,height=200\');
					jQuery("#processing").hide();
				}
			}

			// イベント表示リクエスト
			function fnceventShow(id)	{
				jQuery("#processing").show();
				jQuery.ajax({
					type: "POST",
					url: "'.$url_base.'data/event2/event_show",
					data: "id=" + id,
					success: function(msg){
						jQuery("#processing").hide();
						jQuery("#res_event_edit").html(msg);
						fncShow(\'div_event_edit\', 1140, 600);
						fncSetDate();
					},
					error:function(){
						jQuery("#processing").hide();
						alert("通信エラーが発生しました。");
					}
				});
			}

			// 新規予約
			function fncyoyakuShow(seminarid)	{
				jQuery("#processing").show();
				jQuery.ajax({
					type: "POST",
					url: "'.$url_base.'data/yoyaku/yoyaku_show",
					data: "seminarid=" + seminarid,
					success: function(msg){
						jQuery("#processing").hide();
						jQuery("#res_event_edit").html(msg);
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

			// イベント入力チェック
			function fnceventPost(formname)	{
				// 日付チェック
				if (jQuery("#edit_hiduke").val() == "")	{
					alert("不正な日付です。確認してください。");
					return false;
				}
				// 時間チェック
				if (jQuery("#edit_sttime").val() > jQuery("#edit_edtime").val())	{
					alert("開始時刻が終了時刻より前です。確認してください。");
					return false;
				}
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
				document.getElementById("eventsubmit").value = "Wait";
				document.getElementById("eventsubmit").disabled = true;
				jQuery("#processing").show();
				jQuery.ajax({
					type: "POST",
					url: "'.$url_base.'data/event2/event_edit",
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

			// イベント削除
			function fncdel(formname)	{
				if (!confirm("このイベントを削除します。よろしいですか？"))	{	return false;	}
				if (!confirm("削除だよ？削除？本当に消すの？？"))	{	return false;	}
				document.getElementById("eventdel").value = "Wait";
				document.getElementById("eventdel").disabled = true;
				jQuery("#processing").show();
				jQuery.ajax({
					type: "POST",
					url: "'.$url_base.'data/event2/event_del",
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

			// イベントコピー
			function fnccopy(formname)	{
				if (!confirm("このイベントをコピーします。よろしいですか？"))	{	return false;	}
				jQuery("#edit_id").val("");
				jQuery("#eventdel").hide();
				jQuery("#edit_ongoogle").attr("checked",false);
				jQuery("#hidden_ongoogle").val("");
				jQuery("#edit_use").attr("checked",false);
				jQuery("#lbl_status").html("コピー中");
				jQuery("#lbl_title").html("***　コピー中！！　***　　");
			}

			// 選択チェック
			function fncallcheck(obj)	{
				jQuery(obj.parentNode.parentNode.parentNode).find("input[type=\'checkbox\']").attr("checked", obj.checked);
			}

			// 一括掲載
			function fncgo()	{
				var chk = jQuery( "input:checked" ).map( function() { return jQuery(this).attr("ap"); }).get().join(",");
				if (chk == \'\')	{
					alert("掲載対象を選択してください。");
				}else{
					if (!confirm("一括掲載を実行します。よろしいですか？"))	{	return false;	}
					jQuery("#processing").show();
					jQuery.ajax({
						type: "POST",
						url: "'.$url_base.'data/event2/event_go",
						data: "id=" + chk,
						success: function(msg){
							jQuery("#processing").hide();
							jQuery("#res_event_edit").html(msg);
							fncShow(\'div_event_edit\', 500, 300);
							goforuse=1;
							setTimeout(\'fncgoforuse()\',500);
						},
						error:function(){
							jQuery("#processing").hide();
							alert("通信エラーが発生しました。");
						}
					});
				}
			}

			// 一括掲載実行
			function fncgoforuse()	{
			if (goforuse == 1)	{
					jQuery.ajax({
						type: "POST",
						url: "'.$url_base.'data/event2/event_goforuse",
						success: function(msg){
							res = eval(msg);
							if (res[0].result == \'END\')	{
								jQuery("#lbl_goforuse").html(res[0].cnt);
								alert(res[0].msg);
								fncHide();
							}
							if (res[0].result == \'OK\')	{
								jQuery("#lbl_goforuse").html(res[0].cnt);
								setTimeout(\'fncgoforuse()\',3000);
							}
							if (res[0].result == \'NG\')	{
								alert(res[0].msg);
								fncHide();
							}
						},
						error:function(){
							jQuery("#processing").hide();
							alert("通信エラーが発生しました。");
						}
					});
				}
			}

			// 一括掲載キャンセル
			function fnccancel()	{
				goforuse = 0;
				alert("一括掲載をキャンセルしました。");
				fncHide();
			}

			// ＣＳＶ出力
			function fncSereventCsv()	{
				jQuery("#processing").show();
				jQuery.ajax({
					type: "POST",
					url: "'.$url_base.'csv/event2/event_csv",
					data: jQuery("#form_event_list").serialize(),
					success: function(msg){
						jQuery("#processing").hide();
						res = eval(msg);
						if (res[0].result == \'OK\')	{
							if (confirm(res[0].msg + "出力しますか？"))	{
								window.open(\''.$url_base.'csv/event2/event_csv/?type=out&\' + jQuery("#form_event_list").serialize(), \'_blank\', \'width=200,height=200\');
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

			// 詳細表示
			function fncshowdesc(id, div)	{
				jQuery("#processing").show();
				jQuery.ajax({
					type: "POST",
					url: "'.$url_base.'data/event2/event_showdesc",
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

			// 日付設定
			function fncSetDate()	{
				$yobi = new Array("日","月","火","水","木","金","土")
				$hiduke = new Date(jQuery("#y").val(), jQuery("#m").val() - 1 ,jQuery("#d").val());
				if ($hiduke.getFullYear() == jQuery("#y").val() && ($hiduke.getMonth() + 1) == jQuery("#m").val() && $hiduke.getDate() == jQuery("#d").val())	{
					jQuery("#edit_hiduke").val(jQuery("#y").val()+"-"+jQuery("#m").val()+"-"+jQuery("#d").val());
					jQuery("#yobi").html("(" + $yobi[$hiduke.getDay()] + "曜日)");
				}else{
					jQuery("#edit_hiduke").val("");
					jQuery("#yobi").html("不正な日付です");
				}
			}

			// ＰＲＥ画面表示
			function fncprecheck()	{

				$place = jQuery(\'input[name="edit_place"]:checked\').val();
				$url  = "";
				$url += "http://www.jawhm.or.jp/seminar/check_seminar.php?navigation=1";
				$url += "&month=" + jQuery("#m option:selected").val();
				$url += "&year=" + jQuery("#y option:selected").val();
				$url += "&place_name=" + $place;
				$url += "&checked_countryname=0&checked_know=0#calendar_start";
				window.open($url, "win_pre", "width=1260, height=700, menubar=yes, toolbar=yes, scrollbars=yes");
			}
		';

		// 検索画面表示
		if ($data_param == 'list')	{
			$body_title[] .= '予約状況リスト';
			$ser_cond = '　　　　<input type="checkbox" name="ser_cxl">キャンセル待ち発生中のイベント';
		}else{
			$body_title[] .= 'イベント一括登録（検索）';
			$ser_cond = '';
		}
		$body[] .= '
			<form id="form_event_list">
				<table>
					<tr>
						<td style="text-align:right;">日付</td>
						<td>
							<input id="ser_hiduke" name="ser_hiduke" size="16" type="text" value="'.date('Y/m/d').'"/>
							　～　
							<input id="ser_hiduketo" name="ser_hiduketo" size="16" type="text" />
						</td>
						<td style="text-align:right;">セミナー番号</td>
						<td>
							<input id="ser_evtno" name="ser_evtno" size="6" type="text" value="'.$e.'" />
						</td>
					</tr>
					<tr>
						<td style="text-align:right;">セミナー区分</td>
						<td colspan="3">
							<input type=checkbox name="free_p1" value="0">無料　
							<input type=checkbox name="free_p2" value="1">有料　
							'.$ser_cond.'
							　　　　　　　　
							<input type=checkbox name="ser_ongoogle">カレンダー登録済みを含む
						</td>
					</tr>
					<tr>
						<td style="text-align:right;">開催地</td>
						<td colspan="3">
							<input type=checkbox name="ser_p1" value="tokyo">東京　
							<input type=checkbox name="ser_p2" value="osaka">大阪　
							<input type=checkbox name="ser_p8" value="nagoya">名古屋　
							<input type=checkbox name="ser_p3" value="fukuoka">福岡　
							<input type=checkbox name="ser_p4" value="sendai">仙台　
							<input type=checkbox name="ser_p7" value="toyama">富山　
							<input type=checkbox name="ser_p5" value="okinawa">沖縄　
							<input type=checkbox name="ser_p6" value="event">その他イベント
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
						<td colspan="2">
							<input class="button_go" type="button" value="一括掲載" id="button_go" onclick="fncgo();"">　
							<input type=button class="button_home" value="仮確認" onclick="window.open(\'http://www.jawhm.or.jp/seminar/check_seminar.php\', \'win_pre\', \'width=1260, height=700, menubar=yes, toolbar=yes, scrollbars=yes\');">　
							<input class="button_csv" type="button" value="CSV" id="sereventcsv" onclick="fncSereventCsv();"">
						</td>
						<td colspan="2" style="text-align:right;">
								<input type="hidden" name="ser_param" value="'.$data_param.'">
								<input class="button_cancel" type="reset" value="clear" onclick="jQuery(\'#res_event_list\').html(\'\');">&nbsp;&nbsp;
								<input class="button_submit" type="button" value="Search" onclick="fncSereventList();"">
						</td>
					</tr>
				</table>
			</form>
			<div id="res_event_list" style=""></div>
			';

		if ($e <> '')	{
			$script .= '
				setTimeout("fncSereventList()",1000);
			';
		}

		// 新規登録表示
		$body_title[] .= '新規イベント';
		$body[] .= '
			<input type=button class="button_save" value="　新しいイベントを登録する" onclick="fnceventShow(\'\');">
			<div id="res_event_edit" style=""></div>
		';

		break;
	case "event_show":
		// イベント編集（新規）
		$id = fnc_getpost('id');
		$cur_id = $id;

		if ($id == '')	{
			$title = '<span style="font-size:14pt;font-weight:bold;color:red;">【一括登録】</span>　新しいイベントを登録する';
			$cur_id = '';
			$cur_use = '0';
			$cur_preuse = '0';
			$cur_hiduke = date('Y-m-d');
			$cur_year = date('Y');
			$cur_month = date('m');
			$cur_day = date('d');
			$cur_sttime = '13:00';
			$cur_edtime = '14:00';
			$cur_place = 'tokyo';
			$cur_title1 = '';
			$cur_title2 = '';
			$cur_desc1 = '';
			$cur_desc2 = '';
			$cur_stat = '0';
			$cur_free = '0';
			$cur_type = '0';
			$cur_pax = '0';
			$cur_booking = '0';
			$cur_waitting = '0';
			$cur_new = '0';
			$cur_seminar_name = '';
			$cur_short_description = '';
			$cur_country_code = '';
			$cur_indicated_option = '';
			$cur_broadcasting = 0;
			$cur_group_color = '';
			$cur_ongoogle='';
			$cur_mailinfo='';
			$cnt = 1;
		}else{
			$title = '<span style="font-size:14pt;font-weight:bold;color:navy;" id="lbl_title"></span><span style="font-size:14pt;font-weight:bold;color:red;">【一括登録】</span>　イベント情報修正';
			try {
				$stt = $db->prepare('SELECT id, hiduke, year(hiduke) as y, month(hiduke) as m, day(hiduke) as d, date_format(starttime,\'%H:%i\') as sttime, date_format(endtime,\'%H:%i\') as edtime, place, k_use, preuse, k_title1, k_title2, k_desc1, k_desc2, k_stat, free, type, pax, booking, waitting, new, seminar_name, short_description, country_code, indicated_option, broadcasting, group_color, ongoogle, mailinfo FROM event_list WHERE id = "'.$cur_id.'"');
				$stt->execute();
				$cnt = 0;
				while($row = $stt->fetch(PDO::FETCH_ASSOC)){
					$cnt++;
					$cur_id = $row['id'];
					$cur_hiduke = $row['hiduke'];
					$cur_year = $row['y'];
					$cur_month = $row['m'];
					$cur_day = $row['d'];
					$cur_sttime = $row['sttime'];
					$cur_edtime = $row['edtime'];
					$cur_place = $row['place'];
					$cur_use = $row['k_use'];
					$cur_preuse = $row['preuse'];
					$cur_stat = $row['k_stat'];
					$cur_title1 = $row['k_title1'];
					$cur_title2 = $row['k_title2'];
					$cur_desc1 = $row['k_desc1'];
					$cur_desc2 = $row['k_desc2'];
					$cur_free = $row['free'];
					$cur_type = $row['type'];
					$cur_pax = $row['pax'];
					$cur_booking = $row['booking'];
					$cur_waitting = $row['waitting'];
					$cur_new = $row['new'];
					$cur_seminar_name = $row['seminar_name'];
					$cur_short_description = $row['short_description'];
					$cur_country_code = $row['country_code'];
					$cur_indicated_option = $row['indicated_option'];
					$cur_broadcasting = $row['broadcasting'];
					$cur_group_color = $row['group_color'];
					$cur_ongoogle = $row['ongoogle'];
					$cur_mailinfo = $row['mailinfo'];
				}
			} catch (PDOException $e) {
				die($e->getMessage());
			}
		}

		if ($cur_use == '1')	{
			$cur_use = '○本掲載';
		}else{
			$cur_use = '×未掲載';
		}
		if ($cur_preuse == '1')	{
			$cur_preuse = ' checked ';
		}else{
			$cur_preuse = '';
		}
		if ($cur_new == '1')	{
			$cur_new = ' checked ';
		}else{
			$cur_new = '';
		}
		$arrowedit_ongoogle = '';
		if ($cur_ongoogle == '1')	{
			$cur_ongoogle = ' checked disabled';
			$arrowedit_ongoogle = '<input type="hidden" id="hidden_ongoogle" name="edit_ongoogle" value="on">';
		}else{
			$cur_ongoogle = '';
		}

		$place['tokyo'] = '';
		$place['osaka'] = '';
		$place['nagoya'] = '';
		$place['fukuoka'] = '';
		$place['sendai'] = '';
		$place['okinawa'] = '';
		$place['event'] = '';
		$place['toyama'] = '';
		$place[$cur_place] = ' checked ';

		$stat['0'] = '';
		$stat['1'] = '';
		$stat['2'] = '';
		$stat[$cur_stat] = ' checked ';

		$free['0'] = '';
		$free['1'] = '';
		$free[$cur_free] = ' checked ';

		for ($idx=0; $idx<=300; $idx++)	{
			$type[$idx] = '';
		}
		$type[$cur_type] = ' selected ';

		$indicated_option[0] = '';
		$indicated_option[1] = '';
		$indicated_option[2] = '';
		$indicated_option[$cur_indicated_option] = ' selected ';

		$broadcasting[0] = '';
		$broadcasting[1] = '';
		$broadcasting[$cur_broadcasting] = ' checked ';

		$country_code['none'] = '';
		$country_code['au'] = '';
		$country_code['ca'] = '';
		$country_code['de'] = '';
		$country_code['dk'] = '';
		$country_code['fr'] = '';
		$country_code['nz'] = '';
		$country_code['uk'] = '';
		$country_code['wd'] = '';
		$country_code[$cur_country_code] = ' selected ';

		$group_color['none'] = '';
		$group_color['#474EE6'] = '';
		$group_color['#E64C48'] = '';
		$group_color['#019240'] = '';
		$group_color['#476EE6'] = '';
		$group_color['#FF612E'] = '';
		$group_color['#FF802F'] = '';
		$group_color['#FB6F31'] = '';
		$group_color['#FF6347'] = '';
		$group_color['#000080'] = '';
		$group_color['#00BFFF'] = '';
		$group_color['#F08080'] = '';
		$group_color['#F4A460'] = '';
		$group_color['#FF1A80'] = '';
		$group_color[$cur_group_color] = ' selected ';


		$msg = '
			<div id="div_event_edit" style="display:none; margin:10px 20px 10px 20px; font-size:10pt; cursor:default;">
				<div style="margin:0 0 10px 0; font-size:12pt; font-weight:bodl;">'.$title.'</dib>
				<form id="form_event_edit">
			<table><tr><td style="vertical-align:top;">
				<table>
					<tr>
						<td class="label2" width="100">掲載</td>
						<td class="infield" width="360">
							[<span id="lbl_status">'.$cur_use.'</span>]
							<input type="checkbox" id="edit_use" name="edit_use" '.$cur_preuse.'>仮掲載　　
							<input type="checkbox" id="edit_new" name="edit_new" '.$cur_new.'>フォローメール不要
							<input type="hidden" id="edit_id" name="edit_id" value="'.$cur_id.'">
						</td>
					</tr>
					<tr>
						<td class="label2">日程</td>
						<td class="infield">
							<input class="calendar" id="edit_hiduke" name="edit_hiduke" size="16" type="hidden" value="'.$cur_hiduke.'" />
							<select id="y" name="y" onchange="fncSetDate();">';
		for ($idx=2010; $idx<=2030; $idx++)	{
			$msg .= '<option value="'.$idx.'"';
			if ($idx == $cur_year)	{
				$msg .= ' selected ';
			}
			$msg .= '>'.$idx.'</option>';
		}
		$msg .= '			</select>年
							<select id="m" name="m" onchange="fncSetDate();">';
		for ($idx=1; $idx<=12; $idx++)	{
			$msg .= '<option value="'.$idx.'"';
			if ($idx == $cur_month)	{
				$msg .= ' selected ';
			}
			$msg .= '>'.$idx.'</option>';
		}
		$msg .= '			</select>月
							<select id="d" name="d" onchange="fncSetDate();">';
		for ($idx=1; $idx<=31; $idx++)	{
			$msg .= '<option value="'.$idx.'"';
			if ($idx == $cur_day)	{
				$msg .= ' selected ';
			}
			$msg .= '>'.$idx.'</option>';
		}
		$msg .= '			</select>日
							<span id="yobi"></span>
						</td>
					</tr>
					<tr>
						<td class="label2">時間</td>
						<td class="infield">
							<select id="edit_sttime" name="edit_sttime">';
		for ($idx=6; $idx<=23; $idx++)	{
			$data = substr("00".$idx,-2).'';
			for ($idx2=0; $idx2<4; $idx2++)	{
				$data2 = $data.':'.substr("00".($idx2 * 15), -2);
				$sel = '';
				if ($data2 == $cur_sttime)	{
					$sel = ' selected ';
				}
				$msg .= '<option value="'.$data2.'"'.$sel.'>'.$data2.'</option>';
			}
		}
		$msg .= '			</select>&nbsp;&nbsp;～&nbsp;
							<select id="edit_edtime" name="edit_edtime">';
		for ($idx=6; $idx<=23; $idx++)	{
			$data = substr("00".$idx,-2).'';
			for ($idx2=0; $idx2<4; $idx2++)	{
				$data2 = $data.':'.substr("00".($idx2 * 15), -2);
				$sel = '';
				if ($data2 == $cur_edtime)	{
					$sel = ' selected ';
				}
				$msg .= '<option value="'.$data2.'"'.$sel.'>'.$data2.'</option>';
			}
		}
		$msg .= '			</select>
						</td>
					</tr>
					<tr>
						<td class="label2">開催地</td>
						<td class="infield">
							<input type="radio" name="edit_place" value="tokyo"'.$place['tokyo'].'>東京&nbsp;
							<input type="radio" name="edit_place" value="osaka"'.$place['osaka'].'>大阪&nbsp;
							<input type="radio" name="edit_place" value="nagoya"'.$place['nagoya'].'>名古屋&nbsp;
							<input type="radio" name="edit_place" value="fukuoka"'.$place['fukuoka'].'>福岡&nbsp;
							<input type="radio" name="edit_place" value="sendai"'.$place['sendai'].'>仙台<br/>
							<input type="radio" name="edit_place" value="toyama"'.$place['toyama'].'>富山&nbsp;
							<input type="radio" name="edit_place" value="okinawa"'.$place['okinawa'].'>沖縄&nbsp;
							<input type="radio" name="edit_place" value="event"'.$place['event'].'>その他イベント&nbsp;
						</td>
					</tr>
					<tr>
						<td class="label2">状態</td>
						<td class="infield">
							<input type=radio name="edit_stat" value="0"'.$stat[0].'>空き　
							<input type=radio name="edit_stat" value="1"'.$stat[1].'>混雑　
							<input type=radio name="edit_stat" value="2"'.$stat[2].'>満席
						</td>
					</tr>
					<tr>
						<td class="label2">種別</td>
						<td class="infield">
							<input type=radio name="edit_free" value="0"'.$free[0].'>無料　
							<input type=radio name="edit_free" value="1"'.$free[1].'>有料　　
							<select id="edit_type" name="edit_type">
								<option value="0"  '.$type[0].'>誰でも参加可能</option>
								<option value="10" '.$type[10].'>初心者</option>
								<option value="20" '.$type[20].'>歩き方</option>
								<option value="30" '.$type[30].'>学校比較</option>
								<option value="40" '.$type[40].'>学生限定</option>
								<option value="50" '.$type[50].'>大学進学</option>
								<option value="60" '.$type[60].'>体験談</option>
								<option value="70" '.$type[70].'>講演</option>
								<option value="81" '.$type[81].'>就職に活かす</option>
								<option value="82" '.$type[82].'>セカンドワーホリビザ</option>
								<option value="83" '.$type[83].'>医療</option>
								<option value="84" '.$type[84].'>ヨーロッパ初心者</option>
								<option value="85" '.$type[85].'>AUS・CAN比較会（懇談）</option>
								<option value="86" '.$type[86].'>ヨーロッパ比較会（懇談）</option>
								<option value="87" '.$type[87].'>英語圏比較会（懇談）</option>
								<option value="88" '.$type[88].'>休職ワーホリ（懇談）</option>
								<option value="89" '.$type[89].'>女性限定（懇談）</option>

								<option value="110"'.$type[110].'>BROWNS</option>
								<option value="120"'.$type[120].'>CCEL</option>
								<option value="130"'.$type[130].'>CIC/CWA</option>
								<option value="135"'.$type[135].'>EMBASSY</option>
								<option value="140"'.$type[140].'>ICQA</option>
								<option value="150"'.$type[150].'>IH(Sydney)</option>
								<option value="152"'.$type[152].'>IH(Vancourver)</option>
								<option value="160"'.$type[160].'>ILAC</option>
								<option value="170"'.$type[170].'>ILSC</option>
								<option value="180"'.$type[180].'>IMPACT</option>
								<option value="190"'.$type[190].'>INFORUM</option>
								<option value="200"'.$type[200].'>KGIBC</option>
								<option value="210"'.$type[210].'>KGIC</option>
								<option value="215"'.$type[215].'>NAVITAS</option>
								<option value="220"'.$type[220].'>NZLC</option>
								<option value="230"'.$type[230].'>PGIC</option>
								<option value="240"'.$type[240].'>SELC</option>
								<option value="250"'.$type[250].'>UMC</option>
								<option value="260"'.$type[260].'>VIVA</option>
							</select>
						</td>
					</tr>
					<tr>
						<td class="label2">規模</td>
						<td class="infield">
							定員：'.field_text('edit_pax', 4, $cur_pax).'　　　
							予約：'.$cur_booking.'　　　
							CXL待ち：'.$cur_waitting.'
						</td>
					</tr>
				<tr><td>&nbsp;</td></tr>

					<tr>
						<td class="label2">アイコン</td>
						<td class="infield">
							<select id="edit_indicated_option" name="edit_indicated_option">
								<option value="0" '.$indicated_option[0].'>無し</option>
								<option value="1" '.$indicated_option[1].'>オススメ（★）</option>
								<option value="2" '.$indicated_option[2].'>ＮＥＷ</option>
							</select>
						</td>
					</tr>
					<tr>
						<td class="label2">Ustream</td>
						<td class="infield">
							<input type=radio name="edit_broadcasting" value="0"'.$broadcasting[0].'>無し　
							<input type=radio name="edit_broadcasting" value="1"'.$broadcasting[1].'>中継セミナー
						</td>
					</tr>

					<tr>
						<td class="label2">国旗表示</td>
						<td class="infield">
							<select id="edit_country_code" name="edit_country_code">
								<option value=""   '.$country_code['none'].'>無し</option>
								<option value="au" '.$country_code['au'].'>オーストラリア</option>
								<option value="ca" '.$country_code['ca'].'>カナダ</option>
								<option value="de" '.$country_code['de'].'>ドイツ</option>
								<option value="dk" '.$country_code['dk'].'>デンマーク</option>
								<option value="fr" '.$country_code['fr'].'>フランス</option>
								<option value="nz" '.$country_code['nz'].'>ニュージーランド</option>
								<option value="uk" '.$country_code['uk'].'>イギリス</option>
								<option value="wd" '.$country_code['wd'].'>ワールドワイド</option>
							</select>
						</td>
					</tr>
					<tr>
						<td class="label2">表示色</td>
						<td class="infield">
							<select id="edit_group_color" name="edit_group_color">
								<option value=""  '.$group_color['none'].'>選んでね</option>
								<option value="#474EE6" '.$group_color['#474EE6'].'>オーストラリア学校</option>
								<option value="#E64C48" '.$group_color['#E64C48'].'>カナダ学校</option>
								<option value="#019240" '.$group_color['#019240'].'>ニュージーランド学校</option>
								<option value="#476EE6" '.$group_color['#476EE6'].'>学校セミナー</option>
								<option value="#FF612E" '.$group_color['#FF612E'].'>初心者セミナー</option>
								<option value="#FF802F" '.$group_color['#FF802F'].'>歩き方セミナー</option>
								<option value="#FB6F31" '.$group_color['#FB6F31'].'>学生限定セミナー</option>
								<option value="#FF6347" '.$group_color['#FF6347'].'>懇談セミナー</option>
								<option value="#000080" '.$group_color['#000080'].'>出発前準備セミナー</option>
								<option value="#00BFFF" '.$group_color['#00BFFF'].'>講演会セミナー</option>
								<option value="#FF1A80" '.$group_color['#FF1A80'].'>交流会</option>
								<option value="#F08080" '.$group_color['#F08080'].'>その他１</option>
								<option value="#F4A460" '.$group_color['#F4A460'].'>その他２</option>
							</select>
						</td>
					</tr>
					<tr>
						<td class="label2">CALタイトル</td>
						<td class="infield">'.field_required('edit_seminar_name', 60, $cur_seminar_name).'</td>
					</tr>
					<tr>
						<td class="label2">CAL補足</td>
						<td class="infield">'.field_text('edit_short_description', 60, $cur_short_description).'</td>
					</tr>


					</table>
			</td><td>
				<table>
					<tr>
						<td class="label2" width="120">カレンダー登録</td>
						<td class="infield"><input type="checkbox" id="edit_ongoogle" name="edit_ongoogle" '.$cur_ongoogle.'>'.$arrowedit_ongoogle.'登録する</td>
					</tr>
					<tr>
						<td class="label2" width="120">タイトル</td>
						<td class="infield">'.field_required('edit_title1', 100, $cur_title1).'</td>
					</tr>
					<tr>
						<td class="label2">内部タイトル</td>
						<td class="infield">'.field_text('edit_title2', 100, $cur_title2).'</td>
					</tr>
					<tr>
						<td class="label2">説明文</td>
						<td class="infield">
							<textarea name="edit_desc1" cols="80" rows="12" style="font-size:9pt;">'.$cur_desc1.'</textarea>
						</td>
					</tr>
					<tr>
						<td class="label2">キーワード</td>
						<td class="infield">
							<textarea name="edit_desc2" cols="80" rows="1" style="font-size:9pt;">'.$cur_desc2.'</textarea>
						</td>
					</tr>
					<tr>
						<td class="label2">メール補足</td>
						<td class="infield">
							<textarea name="edit_mailinfo" cols="80" rows="3" style="font-size:9pt;">'.$cur_mailinfo.'</textarea>
						</td>
					</tr>
					<tr>
						<td colspan="2" style="text-align:right;">';
						if ($id <> '' && $cur_ongoogle == '')	{
							$msg .= '<input type=button class="button_del" value="削除" id="eventdel" onclick="fncdel(\'form_event_edit\');">　　　　　';
						}
						$msg .= '
							<input type=button class="button_home" value="仮確認" onclick="fncprecheck();">
							<input type=button class="button_list" value="アイコン" onclick="window.open(\'http://www.jawhm.or.jp/mailsystem/icon.php\', \'win_icon\', \'width=500, height=600, menubar=no, toolbar=no, scrollbars=yes\');">
							<input type=button class="button_save" value="　画像　" onclick="window.open(\'http://www.jawhm.or.jp/mailsystem/tools/upload/\', \'win_icon\', \'width=1000, height=600, menubar=no, toolbar=no, scrollbars=yes\');">　
						';
						if ($id <> '')	{
							$msg .= '<input type=button class="button_copy" value="コピー" id="eventcopy" onclick="fnccopy(\'form_event_edit\');">　';
						}
						$msg .= '　
							<input type=button class="button_cancel" value="やめる" onclick="fncHide();">　　
							<input type=button class="button_submit" value="登録" id="eventsubmit" onclick="fnceventPost(\'form_event_edit\');">
						</td>
					</tr>
				</table>
			</td></tr></table>
				</form>
			</div>
		';
		if ($cnt == 0)	{
			$msg = '
				<div id="div_event_edit" style="display:none; margin:10px 20px 10px 20px; font-size:10pt; cursor:default;">
					<div style="margin:20px 0 30px 0; font-size:12pt; font-weight:bodl;">該当イベントがありません</dib>
					<center>
						<form id="form_event_edit">
								<input type=button class="button_cancel" value="やめる" onclick="fncHide();">　　
						</form>
					</center>
				</div>
			';
		}

		$body[] .= $msg;
		break;

	case "event_edit":
		// イベント情報修正

		$edit_id = fnc_getpost('edit_id');
		$edit_use = fnc_getpost('edit_use');
		$edit_hiduke = fnc_getpost('edit_hiduke');
		$edit_sttime = fnc_getpost('edit_sttime');
		$edit_edtime = fnc_getpost('edit_edtime');
		$edit_place = fnc_getpost('edit_place');
		$edit_title1 = fnc_getpost('edit_title1');
		$edit_title2 = fnc_getpost('edit_title2');
		$edit_desc1 = fnc_getpost('edit_desc1');
		$edit_desc2 = fnc_getpost('edit_desc2');
		$edit_stat = fnc_getpost('edit_stat');
		$edit_free = fnc_getpost('edit_free');
		$edit_type = fnc_getpost('edit_type');
		$edit_pax = fnc_getpost('edit_pax');
		$edit_new = fnc_getpost('edit_new');

		$edit_seminar_name = fnc_getpost('edit_seminar_name');
		$edit_short_description = fnc_getpost('edit_short_description');
		$edit_country_code = fnc_getpost('edit_country_code');
		$edit_indicated_option = fnc_getpost('edit_indicated_option');
		$edit_broadcasting = fnc_getpost('edit_broadcasting');
		$edit_group_color = fnc_getpost('edit_group_color');
		$edit_ongoogle = fnc_getpost('edit_ongoogle');
		$edit_mailinfo = fnc_getpost('edit_mailinfo');

		if ($edit_use == 'on')	{
			$edit_use = '1';
		}else{
			$edit_use = '0';
		}
		if ($edit_new == 'on')	{
			$edit_new = '1';
		}else{
			$edit_new = '0';
		}
		if ($edit_ongoogle == 'on')	{
			$edit_ongoogle = '1';
		}else{
			$edit_ongoogle = '0';
		}

		try {
			if ($edit_id == '')	{
				// 新規登録
				$sql  = 'INSERT INTO event_list (';
				$sql .= ' hiduke, starttime, endtime, place, preuse, k_title1, k_title2, k_desc1, k_desc2, k_stat, free, type, pax, new, seminar_name, short_description, country_code, indicated_option, broadcasting, group_color, ongoogle, mailinfo ';
				$sql .= ') VALUES (';
				$sql .= ' :hiduke, :sttime, :edtime, :place, :preuse, :k_title1, :k_title2, :k_desc1, :k_desc2, :k_stat, :free, :type, :pax, :new, :seminar_name, :short_description, :country_code, :indicated_option, :broadcasting, :group_color, :ongoogle, :mailinfo ';
				$sql .= ')';
				$stt2 = $db->prepare($sql);
				$stt2->bindValue(':hiduke'	, $edit_hiduke);
				$stt2->bindValue(':sttime'	, $edit_hiduke." ".$edit_sttime);
				$stt2->bindValue(':edtime'	, $edit_hiduke." ".$edit_edtime);
				$stt2->bindValue(':place'	, $edit_place);
		//		$stt2->bindValue(':k_use'	, $edit_use);
				$stt2->bindValue(':preuse'	, $edit_use);
				$stt2->bindValue(':k_title1', $edit_title1);
				$stt2->bindValue(':k_title2', $edit_title2);
				$stt2->bindValue(':k_desc1'	, $edit_desc1);
				$stt2->bindValue(':k_desc2'	, $edit_desc2);
				$stt2->bindValue(':k_stat'	, $edit_stat);
				$stt2->bindValue(':free'	, $edit_free);
				$stt2->bindValue(':type'	, $edit_type);
				$stt2->bindValue(':pax'		, $edit_pax);
				$stt2->bindValue(':new'		, $edit_new);
				$stt2->bindValue(':seminar_name'		, $edit_seminar_name);
				$stt2->bindValue(':short_description'	, $edit_short_description);
				$stt2->bindValue(':country_code'		, $edit_country_code);
				$stt2->bindValue(':indicated_option'	, $edit_indicated_option);
				$stt2->bindValue(':broadcasting'		, $edit_broadcasting);
				$stt2->bindValue(':group_color'			, $edit_group_color);
				$stt2->bindValue(':ongoogle'			, $edit_ongoogle);
				$stt2->bindValue(':mailinfo'			, $edit_mailinfo);
				$stt2->execute();
				$arr = array(
					array(
					"result" => "OK",
					"msg"  => "登録しました"
					)
				);
				// イベントＩＤを取得
				$stt = $db->prepare('SELECT max(id) as maxid FROM event_list');
				$stt->execute();
				$idx = 0;
				while($row = $stt->fetch(PDO::FETCH_ASSOC)){
					$idx++;
					$edit_id = $row['maxid'];
				}
			}else{
				// 既存更新
				$sql  = 'UPDATE event_list SET ';
				$sql .= '  hiduke = "'.$edit_hiduke.'"';
				$sql .= ', starttime = "'.$edit_hiduke.' '.$edit_sttime.'"';
				$sql .= ', endtime = "'.$edit_hiduke.' '.$edit_edtime.'"';
				$sql .= ', place = "'.$edit_place.'"';
		//		$sql .= ', k_use = "'.$edit_use.'"';
				$sql .= ', preuse = "'.$edit_use.'"';
				$sql .= ', k_title1 = :k_title1 ';
				$sql .= ', k_title2 = :k_title2 ';
				$sql .= ', k_desc1 = :k_desc1 ';
				$sql .= ', k_desc2 = :k_desc2 ';
				$sql .= ', k_stat = "'.$edit_stat.'"';
				$sql .= ', free = "'.$edit_free.'"';
				$sql .= ', type = "'.$edit_type.'"';
				$sql .= ', pax = "'.$edit_pax.'"';
				$sql .= ', new = "'.$edit_new.'"';

				$sql .= ', seminar_name = :seminar_name';
				$sql .= ', short_description = :short_description';
				$sql .= ', country_code = :country_code';
				$sql .= ', indicated_option = :indicated_option';
				$sql .= ', broadcasting = :broadcasting';
				$sql .= ', group_color = :group_color';
				$sql .= ', ongoogle = :ongoogle';
				$sql .= ', mailinfo = :mailinfo';

				$sql .= ' WHERE id = "'.$edit_id.'"';
				$stt = $db->prepare($sql);
				$stt->bindValue(':k_title1', $edit_title1);
				$stt->bindValue(':k_title2', $edit_title2);
				$stt->bindValue(':k_desc1' , $edit_desc1);
				$stt->bindValue(':k_desc2' , $edit_desc2);
				$stt->bindValue(':seminar_name'		, $edit_seminar_name);
				$stt->bindValue(':short_description', $edit_short_description);
				$stt->bindValue(':country_code'		, $edit_country_code);
				$stt->bindValue(':indicated_option'	, $edit_indicated_option);
				$stt->bindValue(':broadcasting'		, $edit_broadcasting);
				$stt->bindValue(':group_color'		, $edit_group_color);
				$stt->bindValue(':ongoogle'		, $edit_ongoogle);
				$stt->bindValue(':mailinfo'		, $edit_mailinfo);
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
		if ($edit_ongoogle == '1')	{
			GC_Edit($edit_id);
		}

		$msg = json_encode($arr);
		$body[] .= $msg;

		break;

	case "event_del":
		// イベント削除

		$edit_id = fnc_getpost('edit_id');

		try {
			if ($edit_id == '')	{
				// 何もしない
			}else{
				// 削除
				$sql  = 'DELETE FROM event_list ';
				$sql .= ' WHERE id = "'.$edit_id.'"';
				$stt = $db->prepare($sql);
				$stt->execute();
				$arr = array(
					array(
					"result" => "OK",
					"msg"  => "削除しました"
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
		if ($edit_ongoogle == '1')	{
				GC_Edit($edit_id);
		}

		$msg = json_encode($arr);
		$body[] .= $msg;

		break;

	case "event_ser":
		// イベント検索

		$ser_hiduke = fnc_getpost('ser_hiduke');
		$ser_hiduketo = fnc_getpost('ser_hiduketo');
		$free_p1 = fnc_getpost('free_p1');
		$free_p2 = fnc_getpost('free_p2');
		$ser_p1 = fnc_getpost('ser_p1');
		$ser_p2 = fnc_getpost('ser_p2');
		$ser_p3 = fnc_getpost('ser_p3');
		$ser_p4 = fnc_getpost('ser_p4');
		$ser_p5 = fnc_getpost('ser_p5');
		$ser_p6 = fnc_getpost('ser_p6');
		$ser_p7 = fnc_getpost('ser_p7');
		$ser_p8 = fnc_getpost('ser_p8');
		$ser_keyword1 = fnc_getpost('ser_keyword1');
		$ser_keyword2 = fnc_getpost('ser_keyword2');
		$ser_keyword3 = fnc_getpost('ser_keyword3');
		$ser_evtno = fnc_getpost('ser_evtno');
		$ser_param = fnc_getpost('ser_param');
		$ser_cxl = fnc_getpost('ser_cxl');
		$ser_ongoogle = fnc_getpost('ser_ongoogle');

		$body_title[] .= 'イベント検索結果';
		$msg = '';
		$cond = ' 1=1 ';

		$cond_msg = '[検索条件] ';
		if ($ser_hiduke <> '')	{
			$cond .= ' and hiduke >= "'.$ser_hiduke.'"';
		}
		if ($ser_hiduketo <> '')	{
			$cond .= ' and hiduke <= "'.$ser_hiduketo.'"';
		}
		if ($free_p1 <> '' || $free_p2 <> '')	{
			$cond .= ' and ( 1=0 ';
			if ($free_p1 <> '')	{	$cond .= ' or free ="0" ';	}
			if ($free_p2 <> '')	{	$cond .= ' or free ="1" ';	}
			$cond .= ' ) ';
		}
		if ($ser_p1 <> '' || $ser_p2 <> '' || $ser_p3 <> '' || $ser_p4 <> '' || $ser_p5 <> '' || $ser_p6 <> '' || $ser_p7 <> '' || $ser_p8 <> '')	{
			$cond .= ' and ( 1=0 ';
			if ($ser_p1 <> '')	{	$cond .= ' or place ="'.$ser_p1.'" ';	}
			if ($ser_p2 <> '')	{	$cond .= ' or place ="'.$ser_p2.'" ';	}
			if ($ser_p3 <> '')	{	$cond .= ' or place ="'.$ser_p3.'" ';	}
			if ($ser_p4 <> '')	{	$cond .= ' or place ="'.$ser_p4.'" ';	}
			if ($ser_p5 <> '')	{	$cond .= ' or place ="'.$ser_p5.'" ';	}
			if ($ser_p6 <> '')	{	$cond .= ' or place ="'.$ser_p6.'" ';	}
			if ($ser_p7 <> '')	{	$cond .= ' or place ="'.$ser_p7.'" ';	}
			if ($ser_p8 <> '')	{	$cond .= ' or place ="'.$ser_p8.'" ';	}
			$cond .= ' ) ';
		}
		if ($ser_keyword1 <> '')	{
			$cond .= ' and ( ';
			$cond .= ' k_title1 like "%'.$ser_keyword1.'%" or ';
			$cond .= ' k_title2 like "%'.$ser_keyword1.'%" or ';
			$cond .= ' k_desc1 like "%'.$ser_keyword1.'%" or ';
			$cond .= ' k_desc2 like "%'.$ser_keyword1.'%" ) ';
		}
		if ($ser_keyword2 <> '')	{
			$cond .= ' and ( ';
			$cond .= ' k_title1 like "%'.$ser_keyword2.'%" or ';
			$cond .= ' k_title2 like "%'.$ser_keyword2.'%" or ';
			$cond .= ' k_desc1 like "%'.$ser_keyword2.'%" or ';
			$cond .= ' k_desc2 like "%'.$ser_keyword2.'%" ) ';
		}
		if ($ser_keyword3 <> '')	{
			$cond .= ' and ( ';
			$cond .= ' k_title1 like "%'.$ser_keyword3.'%" or ';
			$cond .= ' k_title2 like "%'.$ser_keyword3.'%" or ';
			$cond .= ' k_desc1 like "%'.$ser_keyword3.'%" or ';
			$cond .= ' k_desc2 like "%'.$ser_keyword3.'%" ) ';
		}
		if ($ser_evtno <> '')	{
			$cond .= ' and id = "'.$ser_evtno.'" ';
		}
		if ($ser_cxl <> '')	{
			$cond .= ' and waitting > 0 ';
		}
		if ($ser_ongoogle == 'on')	{
			// 全てを検索する
		}else{
			// カレンダー未登録のみ
			$cond .= ' and ongoogle = 0 ';
		}

		// イベント検索
		$msg .= '<table class="listdata2">';
		$msg .= '<tr>';
		$msg .= '<th><input type="checkbox" onclick="fncallcheck(this);"></th>';
		$msg .= '<th>編集</th>';
		$msg .= '<th width="85">日付<br/>開始</th>';
		$msg .= '<th width="75">開催地<br/>状態</th>';
		$msg .= '<th width="">タイトル</th>';
		$msg .= '</tr>';

		try {
			$stt = $db->prepare('SELECT id, hiduke, date_format(starttime,\'%H:%i\') as sttime, date_format(endtime,\'%H:%i\') as edtime, place, k_use, preuse, k_title1, k_title2, k_desc1, k_desc2, k_stat FROM event_list WHERE '.$cond.' ORDER BY hiduke, starttime, place');
			$stt->execute();
			$idx = 0;
			while($row = $stt->fetch(PDO::FETCH_ASSOC)){
				$idx++;
				$cur_id = $row['id'];
				$cur_hiduke = $row['hiduke'];
				$cur_sttime = $row['sttime'];
				$cur_edtime = $row['edtime'];
				$cur_place = $row['place'];
				$cur_title = $row['k_title1'];
				$cur_use = $row['k_use'];
				$cur_preuse = $row['preuse'];
				$cur_stat = $row['k_stat'];

				if ($idx % 2 == 0)	{
					$msg .= '<tr>';
				}else{
					$msg .= '<tr class="odd">';
				}
				$msg .= '<td><input type="checkbox" id="check_'.$cur_id.'" ap="'.$cur_id.'" class="selchk" onclick=""></td>';
				$msg .= '<td><input type=button class="button_save" value=" 修正" onclick="fnceventShow(\''.$cur_id.'\');"><br/>';
		//		$msg .= '<input type=button class="button_rev" value=" 予約" onclick="fncyoyakuShow(\''.$cur_id.'\');"></td>';
				$msg .= '</td>';
				$msg .= '<td>'.$cur_hiduke.'<br/>'.$cur_sttime.'-'.$cur_edtime.'</td>';
				$msg .= '<td>';
				switch ($cur_place)	{
					case 'tokyo':
						$msg .= '[東京]';
						break;
					case 'osaka':
						$msg .= '[大阪]';
						break;
					case 'nagoya':
						$msg .= '[名古屋]';
						break;
					case 'fukuoka':
						$msg .= '[福岡]';
						break;
					case 'sendai':
						$msg .= '[仙台]';
						break;
					case 'toyama':
						$msg .= '[富山]';
						break;
					case 'okinawa':
						$msg .= '[沖縄]';
						break;
					case 'event':
						$msg .= '[イベント]';
						break;
				}
				$msg .= '<br/>';
				if ($cur_use == '1')	{
					$msg .= '掲';
				}else{
					$msg .= '未';
				}
				$msg .= '/';
				if ($cur_preuse == '1')	{
					$msg .= '仮';
				}else{
					$msg .= '未';
				}
				switch ($cur_stat)	{
					case '0':
						$msg .= '(空)';
						break;
					case '1':
						$msg .= '(混)';
						break;
					case '2':
						$msg .= '<b>(満席)</b>';
						break;
				}
				$msg .= '</td>';
				$msg .= '<td><a id="list'.$cur_id.'" href="#'.$cur_id.'" onclick="fncshowdesc(\''.$cur_id.'\',\'div_'.$cur_id.'\');">'.$cur_title.'</a><div id="div_'.$cur_id.'"></div></td>';
				$msg .= '</tr>';
			}
		} catch (PDOException $e) {
			die($e->getMessage());
		}
		$msg .= '</table>';

		$body[] .= '[該当件数] '.$idx.'件'.$msg;

		break;

	case "event_showdesc":
		// 詳細表示

		$cur_id = fnc_getpost('id');

		try {
			$stt = $db->prepare('SELECT id, hiduke, date_format(starttime,\'%H:%i\') as sttime, date_format(endtime,\'%H:%i\') as edtime, place, k_use, k_title1, k_title2, k_desc1, k_desc2, k_stat, free, type, pax, booking, waitting FROM event_list WHERE id = '.$cur_id.' ORDER BY id');
			$stt->execute();
			$idx = 0;
			while($row = $stt->fetch(PDO::FETCH_ASSOC)){
				$idx++;
				$cur_id = $row['id'];
				$cur_sttime = $row['sttime'];
				$cur_edtime = $row['edtime'];
				$cur_title1 = $row['k_title1'];
				$cur_title2 = $row['k_title2'];
				$cur_desc1 = $row['k_desc1'];
				$cur_desc2 = $row['k_desc2'];
				$cur_free = $row['free'];
				$cur_type = $row['type'];
				$cur_pax = $row['pax'];
				$cur_booking = $row['booking'];
				$cur_waitting = $row['waitting'];
				$cur_hiduke = $row['hiduke'];
				$cur_place = $row['place'];

				$msg  = '<table border="1">';
				$msg .= '<tr><td colspan="3">'.$cur_title2.'</td></tr>';
				$msg .= '<tr><td colspan="3">'.nl2br($cur_desc1).'</td></tr>';
				$msg .= '<tr><td colspan="3">'.nl2br($cur_desc2).'</td></tr>';
				$msg .= '<tr><td>';
				if ($cur_free == '0')	{
					$msg .= '無料';
				}else{
					$msg .= '有料';
				}
				$msg .= '</td>';
				$msg .= '<td>';
				switch ($cur_type)	{
					case '0':
						$msg .= '誰でも';
						break;
					case '1':
						$msg .= '初心者';
						break;
					case '2':
						$msg .= '歩き方';
						break;
					case '3':
						$msg .= '専門';
						break;
				}
				$msg .= '</td>';
				$msg .= '<td>&nbsp;予約件数 ： '.$cur_booking.'&nbsp;('.$cur_waitting.') / '.$cur_pax;
				$msg .= '　　<input type="button" class="button_list" value="　一覧" onclick="window.location.href=\''.$url_base.'main/yoyaku?seminarid='.$cur_id.'\'">';
				$msg .= '　<input type="button" class="button_save" value="CSV" onclick="fncYoyakuListCsv(\''.$cur_hiduke.'\',\''.$cur_place.'\');">';
				$msg .= '</td>';
				$msg .= '</tr>';
				$msg .= '<tr><td colspan="3">&nbsp;時刻 ： '.$cur_sttime.'　～　'.$cur_edtime.'</td></tr>';
				$msg .= '<tr><td colspan="3"><input type="text" size="100" value="http://www.jawhm.or.jp/s/go/'.$cur_id.'"></td></tr>';
				$msg .= '</table>';
				$msg .= '';
			}
		} catch (PDOException $e) {
			die($e->getMessage());
		}
		$body[] .= $msg;

		break;

	case "event_csv":
		// イベントＣＳＶ出力

		$type = fnc_getpost('type');

		$ser_hiduke = fnc_getpost('ser_hiduke');
		$ser_hiduketo = fnc_getpost('ser_hiduketo');
		$free_p1 = fnc_getpost('free_p1');
		$free_p2 = fnc_getpost('free_p2');
		$ser_p1 = fnc_getpost('ser_p1');
		$ser_p2 = fnc_getpost('ser_p2');
		$ser_p3 = fnc_getpost('ser_p3');
		$ser_p4 = fnc_getpost('ser_p4');
		$ser_p5 = fnc_getpost('ser_p5');
		$ser_p6 = fnc_getpost('ser_p6');
		$ser_p7 = fnc_getpost('ser_p7');
		$ser_p8 = fnc_getpost('ser_p8');
		$ser_keyword1 = fnc_getpost('ser_keyword1');
		$ser_keyword2 = fnc_getpost('ser_keyword2');
		$ser_keyword3 = fnc_getpost('ser_keyword3');
		$ser_evtno = fnc_getpost('ser_evtno');
		$ser_param = fnc_getpost('ser_param');
		$ser_cxl = fnc_getpost('ser_cxl');

		$body_title[] .= 'イベント検索結果';
		$msg = '';
		$cond = ' 1=1 ';

		$cond_msg = '[検索条件] ';
		if ($ser_hiduke <> '')	{
			$cond .= ' and hiduke >= "'.$ser_hiduke.'"';
		}
		if ($ser_hiduketo <> '')	{
			$cond .= ' and hiduke <= "'.$ser_hiduketo.'"';
		}
		if ($free_p1 <> '' || $free_p2 <> '')	{
			$cond .= ' and ( 1=0 ';
			if ($free_p1 <> '')	{	$cond .= ' or free ="0" ';	}
			if ($free_p2 <> '')	{	$cond .= ' or free ="1" ';	}
			$cond .= ' ) ';
		}
		if ($ser_p1 <> '' || $ser_p2 <> '' || $ser_p3 <> '' || $ser_p4 <> '' || $ser_p5 <> '' || $ser_p6 <> '' || $ser_p7 <> '' || $ser_p8 <> '')	{
			$cond .= ' and ( 1=0 ';
			if ($ser_p1 <> '')	{	$cond .= ' or place ="'.$ser_p1.'" ';	}
			if ($ser_p2 <> '')	{	$cond .= ' or place ="'.$ser_p2.'" ';	}
			if ($ser_p3 <> '')	{	$cond .= ' or place ="'.$ser_p3.'" ';	}
			if ($ser_p4 <> '')	{	$cond .= ' or place ="'.$ser_p4.'" ';	}
			if ($ser_p5 <> '')	{	$cond .= ' or place ="'.$ser_p5.'" ';	}
			if ($ser_p6 <> '')	{	$cond .= ' or place ="'.$ser_p6.'" ';	}
			if ($ser_p7 <> '')	{	$cond .= ' or place ="'.$ser_p7.'" ';	}
			if ($ser_p8 <> '')	{	$cond .= ' or place ="'.$ser_p8.'" ';	}
			$cond .= ' ) ';
		}
		if ($ser_keyword1 <> '')	{
			$cond .= ' and ( ';
			$cond .= ' k_title1 like "%'.$ser_keyword1.'%" or ';
			$cond .= ' k_title2 like "%'.$ser_keyword1.'%" or ';
			$cond .= ' k_desc1 like "%'.$ser_keyword1.'%" or ';
			$cond .= ' k_desc2 like "%'.$ser_keyword1.'%" ) ';
		}
		if ($ser_keyword2 <> '')	{
			$cond .= ' and ( ';
			$cond .= ' k_title1 like "%'.$ser_keyword2.'%" or ';
			$cond .= ' k_title2 like "%'.$ser_keyword2.'%" or ';
			$cond .= ' k_desc1 like "%'.$ser_keyword2.'%" or ';
			$cond .= ' k_desc2 like "%'.$ser_keyword2.'%" ) ';
		}
		if ($ser_keyword3 <> '')	{
			$cond .= ' and ( ';
			$cond .= ' k_title1 like "%'.$ser_keyword3.'%" or ';
			$cond .= ' k_title2 like "%'.$ser_keyword3.'%" or ';
			$cond .= ' k_desc1 like "%'.$ser_keyword3.'%" or ';
			$cond .= ' k_desc2 like "%'.$ser_keyword3.'%" ) ';
		}
		if ($ser_evtno <> '')	{
			$cond .= ' and id = "'.$ser_evtno.'" ';
		}
		if ($ser_cxl <> '')	{
			$cond .= ' and waitting > 0 ';
		}

		// イベント検索
		$msg  = '';
		$msg .= '"登録"';
		$msg .= ',"セミナー番号"';
		$msg .= ',"掲載"';
		$msg .= ',"日付"';
		$msg .= ',"開始時刻"';
		$msg .= ',"終了時刻"';
		$msg .= ',"開催地"';
		$msg .= ',"状態"';
		$msg .= ',"種別１"';
		$msg .= ',"種別２"';
		$msg .= ',"定員"';
		$msg .= ',"アイコン"';
		$msg .= ',"中継"';
		$msg .= ',"国旗"';
		$msg .= ',"表示色"';
		$msg .= ',"ＣＡＬタイトル"';
		$msg .= ',"ＣＡＬ補足"';
		$msg .= ',"タイトル"';
		$msg .= ',"内部タイトル"';
		$msg .= ',"説明文"';
		$msg .= ',"キーワード"';
		$msg .= chr(13).chr(10);

		try {
			$sql  = '';
			$sql .= 'SELECT';
			$sql .= '  id';
			$sql .= ' ,hiduke';
			$sql .= ' ,date_format(starttime,\'%H:%i\') as sttime';
			$sql .= ' ,date_format(endtime,\'%H:%i\') as edtime';
			$sql .= ' ,place';
			$sql .= ' ,k_use, preuse';
			$sql .= ' ,k_title1';
			$sql .= ' ,k_title2';
			$sql .= ' ,k_desc1';
			$sql .= ' ,k_desc2';
			$sql .= ' ,k_stat';
			$sql .= ' ,free';
			$sql .= ' ,type';
			$sql .= ' ,pax';
			$sql .= ' ,seminar_name';
			$sql .= ' ,short_description';
			$sql .= ' ,country_code';
			$sql .= ' ,indicated_option';
			$sql .= ' ,broadcasting';
			$sql .= ' ,group_color';
			$sql .= ' FROM event_list WHERE '.$cond.' ORDER BY hiduke, starttime, place';
			$stt = $db->prepare($sql);
			$stt->execute();
			$idx = 0;
			while($row = $stt->fetch(PDO::FETCH_ASSOC)){
				$idx++;

				$cur_id = $row['id'];
		//		$cur_use = $row['k_use'];
				$cur_use = $row['preuse'];
				$cur_hiduke = $row['hiduke'];
				$cur_sttime = $row['sttime'];
				$cur_edtime = $row['edtime'];
				$cur_place = $row['place'];
				$cur_stat = $row['k_stat'];
				$cur_free = $row['free'];
				$cur_type = $row['type'];
				$cur_pax = $row['pax'];
				$cur_indicated_option = $row['indicated_option'];
				$cur_broadcasting = $row['broadcasting'];
				$cur_country_code = $row['country_code'];
				$cur_group_color = $row['group_color'];
				$cur_seminar_name = $row['seminar_name'];
				$cur_short_description = $row['short_description'];
				$cur_title1 = $row['k_title1'];
				$cur_title2 = $row['k_title2'];
				$cur_desc1 = $row['k_desc1'];
				$cur_desc2 = $row['k_desc2'];

				$msg .= '"既存"';
				$msg .= ',"'.$cur_id.'"';
				$msg .= ',"'.$cur_use.'"';
				$msg .= ',"'.$cur_hiduke.'"';
				$msg .= ',"'.$cur_sttime.'"';
				$msg .= ',"'.$cur_edtime.'"';
				$msg .= ',"'.$cur_place.'"';
				$msg .= ',"'.$cur_stat.'"';
				$msg .= ',"'.$cur_free.'"';
				$msg .= ',"'.$cur_type.'"';
				$msg .= ',"'.$cur_pax.'"';
				$msg .= ',"'.$cur_indicated_option.'"';
				$msg .= ',"'.$cur_broadcasting.'"';
				$msg .= ',"'.$cur_country_code.'"';
				$msg .= ',"'.$cur_group_color.'"';
				$msg .= ',"'.$cur_seminar_name.'"';
				$msg .= ',"'.$cur_short_description.'"';
				$msg .= ',"'.$cur_title1.'"';
				$msg .= ',"'.$cur_title2.'"';
				$msg .= ',"'.$cur_desc1.'"';
				$msg .= ',"'.$cur_desc2.'"';

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

	case "event_go":
		// 一括掲載
		$edit_ids = fnc_getpost('id');

		$arr_id = explode(',' , $edit_ids);

		$err_msg = '';
		$tbl_msg = '';

		try {
			// 一回クリア
			$stt = $db->prepare('UPDATE event_list SET goforuse = 0 WHERE goforuse = 1');
			$stt->execute();
			// 該当イベント設定
			$no  = 0;
			$idx = 0;
			while ($idx<count($arr_id))	{
				$stt = $db->prepare('UPDATE event_list SET goforuse = 1 WHERE id = "'.$arr_id[$idx].'"');
				$stt->execute();
				$idx++;
			}
		} catch (PDOException $e) {
			die($e->getMessage());
		}

		$msg  = '';
		$msg .= '
				<div id="div_event_edit" style="display:none; margin:10px 20px 10px 20px; padding: 10px 10px 10px 10px; font-size:10pt; cursor:default; background-color:green; color:white;">
					<div style="font-size:14pt; font-weight:bold;">【　一括掲載　】</div>
					<div style="width:480px; height:60px; text-align:center; font-size:14pt; padding:20px 0 20px 0;">
						あと、<span id="lbl_goforuse">'.$idx.'</span>件のイベント掲載を処理します。<br/>
						このまましばらくお待ちください。<br/>
					</div>
					<div style="text-align:right; width:400px;">
						<input type=button class="button_cancel" value="　中断　" onclick="fnccancel();">
					</div>
				</div>
			</div>
		';

		$body[] .= $msg;

		break;

	case "event_goforuse":
		// 一括掲載実行

		try {
			$sql  = '';
			$sql .= 'SELECT';
			$sql .= '  id';
			$sql .= ' FROM event_list WHERE goforuse = 1 ORDER BY hiduke DESC, starttime DESC, place DESC';
			$stt = $db->prepare($sql);
			$stt->execute();
			$cnt = 0;
			while($row = $stt->fetch(PDO::FETCH_ASSOC)){
				$cnt++;
				$cur_id = $row['id'];
			}

			// 掲載実行
			$stt = $db->prepare('UPDATE event_list SET k_use = preuse, ongoogle = 1, goforuse = 0 WHERE id = "'.$cur_id.'"');
			$stt->execute();

			// カレンダー掲載
			GC_Edit($cur_id);

			if ($cnt == 1)	{
				$arr = array(
					array(
					"result" => "END",
					"cnt" => $cnt,
					"msg"  => "一括掲載が完了しました。"
					)
				);
			}else{
				$arr = array(
					array(
					"result" => "OK",
					"cnt" => $cnt,
					"msg"  => "残処理があります。"
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


}

?>