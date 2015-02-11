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
			// カレンダー表示
			InputCalendar.createOnLoaded(\'ser_hiduke\', {lang:\'ja\'});
			InputCalendar.createOnLoaded(\'ser_hiduketo\', {lang:\'ja\'});

			// イベント検索
			function fncSereventList()	{
				jQuery("#processing").show();
				jQuery.ajax({
					type: "POST",
					url: "'.$url_base.'data/event/event_ser",
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
					url: "'.$url_base.'data/event/event_show",
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
					url: "'.$url_base.'data/event/event_edit",
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

			function fncSereventCsv()	{
				jQuery("#processing").show();
				jQuery.ajax({
					type: "POST",
					url: "'.$url_base.'csv/event/event_csv",
					data: jQuery("#form_event_list").serialize(),
					success: function(msg){
						jQuery("#processing").hide();
						res = eval(msg);
						if (res[0].result == \'OK\')	{
							if (confirm(res[0].msg + "出力しますか？"))	{
								window.open(\''.$url_base.'csv/event/event_csv/?type=out&\' + jQuery("#form_event_list").serialize(), \'_blank\', \'width=200,height=200\');
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
					url: "'.$url_base.'data/event/event_showdesc",
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
		';

		// 検索画面表示
		if ($data_param == 'list')	{
			$body_title[] .= '予約状況リスト';
			$ser_cond = '　　　　<input type="checkbox" name="ser_cxl">キャンセル待ち発生中のイベント';
		}else{
			$body_title[] .= 'イベント検索';
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
                
                // load list template mail
                try {
                    $sql = "SELECT * FROM mailtext WHERE keycd LIKE 'mail_temp' ORDER BY id";
                    $stt = $db->prepare($sql);
                    $stt->execute();
                    while ($row = $stt->fetch(PDO::FETCH_ASSOC)) {
                        $id_mail_temp = $row['id'];
                        $list_mail_template[$id_mail_temp] = $row['text1'];
                    }
                } catch (PDOException $e) {
                    die($e->getMessage());
                }

		if ($id == '')	{
			$title = '【新しいイベントを登録する】';
			$cur_id = '';
			$cur_use = '0';
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
                        // first template created is a default template
                        if ($list_mail_template != NULL){
                            foreach($list_mail_template as $k=>$v){
                                $cur_type = $k;
                                break;
                            }
                        } else {
                            $cur_type = '0';
                        }
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
			$cur_mailinfo='';
                        $cur_beginer = 0;
		}else{
			$title = '【イベント情報修正】';
			try {
				$stt = $db->prepare('SELECT id, hiduke, year(hiduke) as y, month(hiduke) as m, day(hiduke) as d, date_format(starttime,\'%H:%i\') as sttime, date_format(endtime,\'%H:%i\') as edtime, place, k_use, k_title1, k_title2, k_desc1, k_desc2, k_stat, free, type, pax, booking, waitting, new, seminar_name, short_description, country_code, indicated_option, broadcasting, group_color, mailinfo, beginer FROM event_list WHERE id = "'.$cur_id.'"');
				$stt->execute();
				$idx = 0;
				while($row = $stt->fetch(PDO::FETCH_ASSOC)){
					$idx++;
					$cur_id = $row['id'];
					$cur_hiduke = $row['hiduke'];
					$cur_year = $row['y'];
					$cur_month = $row['m'];
					$cur_day = $row['d'];
					$cur_sttime = $row['sttime'];
					$cur_edtime = $row['edtime'];
					$cur_place = $row['place'];
					$cur_use = $row['k_use'];
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
					$cur_mailinfo = $row['mailinfo'];
					$cur_beginer = $row['beginer'];
				}
			} catch (PDOException $e) {
				die($e->getMessage());
			}
		}

		if ($cur_use == '1')	{
			$cur_use = ' checked ';
		}else{
			$cur_use = '';
		}
		if ($cur_new == '1')	{
			$cur_new = ' checked ';
		}else{
			$cur_new = '';
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
                
                $beginer = ($cur_beginer == 0)?'':' checked ';
                
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
			<div id="div_event_edit" style="display:none; margin:10px 20px 10px 20px; font-size:10pt; cursor:default; overflow-y:auto; height: 500px;">
				<div style="margin:0 0 10px 0; font-size:12pt; font-weight:bold;">'.$title.'</dib>
				<form id="form_event_edit">
			<table><tr><td style="vertical-align:top;">
				<table>
					<tr>
						<td class="label" width="100">掲載</td>
						<td class="infield" width="360">
							<input type="checkbox" id="edit_use" name="edit_use" '.$cur_use.'>掲載する　　　　　
							<input type="checkbox" id="edit_new" name="edit_new" '.$cur_new.'>フォローメール不要
							<input type="hidden" name="edit_id" value="'.$cur_id.'">
						</td>
					</tr>
					<tr>
						<td class="label">日程</td>
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
						<td class="label">時間</td>
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
						<td class="label">開催地</td>
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
						<td class="label">状態</td>
						<td class="infield">
							<input type=radio name="edit_stat" value="0"'.$stat[0].'>空き　
							<input type=radio name="edit_stat" value="1"'.$stat[1].'>混雑　
							<input type=radio name="edit_stat" value="2"'.$stat[2].'>満席
						</td>
					</tr>
					<tr>
						<td class="label">種別</td>
						<td class="infield">
							<input type=radio name="edit_free" value="0"'.$free[0].'>無料　
							<input type=radio name="edit_free" value="1"'.$free[1].'>有料
                                                        ' . dropdown_list('edit_type', $cur_type, $list_mail_template, array('empty' => 'メールを送信しない')) . '    
						</td>
					</tr>
					<tr>
						<td class="label">規模</td>
						<td class="infield">
							定員：'.field_text('edit_pax', 4, $cur_pax).'　　　
							予約：'.$cur_booking.'　　　
							CXL待ち：'.$cur_waitting.'
						</td>
					</tr>
                                        <tr>
                                                <td class="label">対象者</td>
                                                <td>
                                                    <label><input type=checkbox name="edit_beginer" ' . $beginer . '>初心者向け</label>
                                                </td>
                                        </tr>
				<tr><td>&nbsp;</td></tr>

					<tr>
						<td class="label">アイコン</td>
						<td class="infield">
							<select id="edit_indicated_option" name="edit_indicated_option">
								<option value="0" '.$indicated_option[0].'>無し</option>
								<option value="1" '.$indicated_option[1].'>オススメ（★）</option>
								<option value="2" '.$indicated_option[2].'>ＮＥＷ</option>
							</select>
						</td>
					</tr>
					<tr>
						<td class="label">Ustream</td>
						<td class="infield">
							<input type=radio name="edit_broadcasting" value="0"'.$broadcasting[0].'>無し　
							<input type=radio name="edit_broadcasting" value="1"'.$broadcasting[1].'>中継セミナー
						</td>
					</tr>

					<tr>
						<td class="label">国旗表示</td>
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
						<td class="label">表示色</td>
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
						<td class="label">CALタイトル</td>
						<td class="infield">'.field_required('edit_seminar_name', 60, $cur_seminar_name).'</td>
					</tr>
					<tr>
						<td class="label">CAL補足</td>
						<td class="infield">'.field_text('edit_short_description', 60, $cur_short_description).'</td>
					</tr>


					</table>
			</td></tr><tr><td>
				<table>
					<tr>
						<td class="label" width="120">タイトル</td>
						<td class="infield">'.field_required('edit_title1', 60, $cur_title1).'</td>
					</tr>
					<tr>
						<td class="label">内部タイトル</td>
						<td class="infield">'.field_text('edit_title2', 60, $cur_title2).'</td>
					</tr>
					<tr>
						<td class="label">説明文</td>
						<td class="infield">
							<textarea name="edit_desc1" cols="80" rows="12" style="font-size:9pt;">'.$cur_desc1.'</textarea>
						</td>
					</tr>
					<tr>
						<td class="label">キーワード</td>
						<td class="infield">
							<textarea name="edit_desc2" cols="80" rows="1" style="font-size:9pt;">'.$cur_desc2.'</textarea>
						</td>
					</tr>
					<tr>
						<td class="label">メール補足</td>
						<td class="infield">
							<textarea name="edit_mailinfo" cols="80" rows="3" style="font-size:9pt;">'.$cur_mailinfo.'</textarea>
						</td>
					</tr>
					<tr>
						<td colspan="2" style="text-align:right;">
							<input type=button class="button_list" value="アイコン" onclick="window.open(\'http://www.jawhm.or.jp/mailsystem/icon.php\', \'win_icon\', \'width=500, height=600, menubar=no, toolbar=no, scrollbars=yes\');">　
							<input type=button class="button_save" value="　画像　" onclick="window.open(\'http://www.jawhm.or.jp/mailsystem/tools/upload/\', \'win_icon\', \'width=1000, height=600, menubar=no, toolbar=no, scrollbars=yes\');">　　　　
							<input type=button class="button_cancel" value="やめる" onclick="fncHide();">　　
							<input type=button class="button_submit" value="登録" id="eventsubmit" onclick="fnceventPost(\'form_event_edit\');">
						</td>
					</tr>
				</table>
			</td></tr></table>
				</form>
			</div>
		';
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
		$edit_mailinfo = fnc_getpost('edit_mailinfo');
                
		$edit_beginer = fnc_getpost('edit_beginer');
                $edit_beginer = ($edit_beginer == 'on')?1:0;

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

		try {
			if ($edit_id == '')	{
				// 新規登録
				$sql  = 'INSERT INTO event_list (';
				$sql .= ' hiduke, starttime, endtime, place, k_use, k_title1, k_title2, k_desc1, k_desc2, k_stat, free, type, pax, new, seminar_name, short_description, country_code, indicated_option, broadcasting, group_color, ongoogle, mailinfo, beginer ';
				$sql .= ') VALUES (';
				$sql .= ' :hiduke, :sttime, :edtime, :place, :k_use, :k_title1, :k_title2, :k_desc1, :k_desc2, :k_stat, :free, :type, :pax, :new, :seminar_name, :short_description, :country_code, :indicated_option, :broadcasting, :group_color, :ongoogle, :mailinfo, :beginer ';
				$sql .= ')';
				$stt2 = $db->prepare($sql);
				$stt2->bindValue(':hiduke'	, $edit_hiduke);
				$stt2->bindValue(':sttime'	, $edit_hiduke." ".$edit_sttime);
				$stt2->bindValue(':edtime'	, $edit_hiduke." ".$edit_edtime);
				$stt2->bindValue(':place'	, $edit_place);
				$stt2->bindValue(':k_use'	, $edit_use);
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
				$stt2->bindValue(':ongoogle'			, 1);
				$stt2->bindValue(':mailinfo'			, $edit_mailinfo);
				$stt2->bindValue(':beginer'			, $edit_beginer);
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
				$sql .= ', k_use = "'.$edit_use.'"';
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
				$sql .= ', ongoogle = 1 ';
				$sql .= ', mailinfo = :mailinfo';
				$sql .= ', beginer = :beginer';

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
				$stt->bindValue(':mailinfo'		, $edit_mailinfo);
				$stt->bindValue(':beginer'		, $edit_beginer);
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
		// GC_Edit($edit_id);  /* Khang comment */

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

		if ($ser_param == 'list')	{
			// 予約状況一覧
			$cond .= ' and k_use = 1';

			$msg .= '<table class="listdata">';
			$msg .= '<tr>';
			$msg .= '<th>操作</th>';
			$msg .= '<th width="">日付・開催地・状態</th>';
			$msg .= '<th width="">タイトル</th>';
			$msg .= '<th width="">定員/予約/C待/予率</th>';
			$msg .= '</tr>';

			try {
				$stt = $db->prepare('SELECT id, hiduke, place, k_use, k_title1, k_title2, k_desc1, k_desc2, k_stat, pax, booking, waitting FROM event_list WHERE '.$cond.' and ongoogle = 1 ORDER BY hiduke, starttime, place');
				$stt->execute();
				$idx = 0;
				while($row = $stt->fetch(PDO::FETCH_ASSOC)){
					$idx++;
					$cur_id = $row['id'];
					$cur_hiduke = $row['hiduke'];
					$cur_place = $row['place'];
					$cur_title = $row['k_title1'];
					$cur_use = $row['k_use'];
					$cur_stat = $row['k_stat'];
					$cur_pax = $row['pax'];
					$cur_booking = $row['booking'];
					$cur_waitting = $row['waitting'];

					$cur_title = strip_tags($cur_title);
					$cur_title = preg_replace("/<img[^>]+\>/i", "", $cur_title);

					if ($idx % 2 == 0)	{
						$msg .= '<tr>';
					}else{
						$msg .= '<tr class="odd">';
					}
					$msg .= '<td><input type=button class="button_save" value="修" onclick="fnceventShow(\''.$cur_id.'\');">';
			//		$msg .= '<input type=button class="button_rev" value="予約" onclick="fncyoyakuShow(\''.$cur_id.'\');">';
					$msg .= '<input type="button" class="button_list" value="一覧" onclick="window.location.href=\''.$url_base.'main/yoyaku?seminarid='.$cur_id.'\'">';
					$msg .= '<input type="button" class="button_save" value="CSV" onclick="fncYoyakuListCsv(\''.$cur_hiduke.'\',\''.$cur_place.'\');">';
					$msg .= '</td>';
					$msg .= '<td>'.$cur_hiduke.'';
					switch ($cur_place)	{
						case 'tokyo':
							$msg .= '[東]';
							break;
						case 'osaka':
							$msg .= '[大]';
							break;
						case 'nagoya':
							$msg .= '[名]';
							break;
						case 'fukuoka':
							$msg .= '[福]';
							break;
						case 'sendai':
							$msg .= '[仙]';
							break;
						case 'toyama':
							$msg .= '[富]';
							break;
						case 'okinawa':
							$msg .= '[沖]';
							break;
						case 'event':
							$msg .= '[イ]';
							break;
					}
					$msg .= '';
					if ($cur_use == '1')	{
						$msg .= '掲';
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
							$msg .= '<b>(満)</b>';
							break;
					}
					$msg .= '</td>';
					$msg .= '<td><input type="text" readonly size="48" value="'.$cur_title.'"></td>';
				//	$msg .= '<td><a id="list'.$cur_id.'" href="#'.$cur_id.'" onclick="fncshowdesc(\''.$cur_id.'\',\'div_'.$cur_id.'\');">'.$cur_title.'</a><div id="div_'.$cur_id.'"></div></td>';
					$msg .= '<td width="160">';
					$msg .= '<table><tr>';
					$msg .= '<td width="40" style="text-align:right;">'.$cur_pax.'</td>';
					$msg .= '<td width="40" style="text-align:right;">'.$cur_booking.'</td>';
					if ($cur_waitting > 0)	{
						$msg .= '<td width="40" style="text-align:right; font-weight:bold; color:white; background-color:red;">'.$cur_waitting.'</td>';
					}else{
						$msg .= '<td width="40" style="text-align:right;">'.$cur_waitting.'</td>';
					}
					if ($cur_pax > 0)	{
						$yoyaku_riyu = $cur_booking / $cur_pax * 100;

						if ($yoyaku_riyu < 30)	{
							$msg .= '<td width="40" style="font-size:10pt; text-align:right; background-color:#7FFF00;">'.number_format($yoyaku_riyu,0).'%</td>';
						}elseif ($yoyaku_riyu < 60 )	{
							$msg .= '<td width="40" style="font-size:10pt; text-align:right; background-color:#FFDAB9;">'.number_format($yoyaku_riyu,0).'%</td>';
						}else{
							$msg .= '<td width="40" style="font-size:10pt; text-align:right;">'.number_format($yoyaku_riyu,0).'%</td>';
						}
					}else{
						$yoyaku_riyu = '';
						$msg .= '<td width="40" style="text-align:right;">&nbsp;</td>';
					}


					$msg .= '</tr></table>';

					$msg .= '</td>';
					$msg .= '</tr>';
				}
			} catch (PDOException $e) {
				die($e->getMessage());
			}
			$msg .= '</table>';

		}else{
			// イベント検索
			$msg .= '<table class="listdata">';
			$msg .= '<tr>';
			$msg .= '<th>編集</th>';
			$msg .= '<th width="85">日付<br/>開始</th>';
			$msg .= '<th width="75">開催地<br/>状態</th>';
			$msg .= '<th width="">タイトル</th>';
			$msg .= '</tr>';

			try {
				$stt = $db->prepare('SELECT id, hiduke, date_format(starttime,\'%H:%i\') as sttime, date_format(endtime,\'%H:%i\') as edtime, place, k_use, k_title1, k_title2, k_desc1, k_desc2, k_stat FROM event_list WHERE '.$cond.' and ongoogle = 1 ORDER BY hiduke, starttime, place');
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
					$cur_stat = $row['k_stat'];

					if ($idx % 2 == 0)	{
						$msg .= '<tr>';
					}else{
						$msg .= '<tr class="odd">';
					}
					$msg .= '<td><input type=button class="button_save" value=" 修正" onclick="fnceventShow(\''.$cur_id.'\');"><br/>';
					$msg .= '<input type=button class="button_rev" value=" 予約" onclick="fncyoyakuShow(\''.$cur_id.'\');"></td>';
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
						$msg .= '掲載';
					}else{
						$msg .= '未掲';
					}
					switch ($cur_stat)	{
						case '0':
							$msg .= '(空き)';
							break;
						case '1':
							$msg .= '(混雑)';
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
		}

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
//		$msg .= ',"説明文"';
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
			$sql .= ' ,k_use';
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
				$cur_use = $row['k_use'];
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
//				$msg .= ',"'.$cur_desc1.'"';
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


}


?>