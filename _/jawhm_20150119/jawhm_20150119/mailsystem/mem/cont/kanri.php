<?php

$menu_title = '';
$menu = '';
$menu_title[] = array();
$menu[] = array();


$menu_title[] .= '一般メニュー';
$menu[] .= '
	<a href="'.$url_base.'main">通常画面へ</a><br/>
';

$menu_title[] .= '管理メニュー';
$menu[] .= '
	<a class="menu_link" href="'.$url_base.'main/kanri">管理メニューＴＯＰ</a><br/>
	<a class="menu_link" href="'.$url_base.'main/kanri/user">担当者管理</a><br/>
	<a class="menu_link" href="'.$url_base.'main/kanri/log">操作ログ</a><br/>
';



if (count($param) > 2) {
	$data_param = $param[2];
}else{
	$data_param = 'main';
}

switch ($data_param)	{
	case "main":
		// 管理画面ＴＯＰ

		$body_title[] .= '簡易集計';
		$body[] .= '

		';
		break;
	case "user":
		// 担当者管理

		// 担当者操作系ＪＳ
		$script .= '
			// 担当者検索
			function fncSerUserList()	{
				jQuery("#processing").show();
				jQuery.ajax({
					type: "POST",
					url: "'.$url_base.'data/kanri/user_ser",
					data: jQuery("#form_user_list").serialize(),
					success: function(msg){
						jQuery("#processing").hide();
						jQuery("#res_user_list").html(msg);
					},
					error:function(){
						jQuery("#processing").hide();
						alert("通信エラーが発生しました。");
					}
				});
			}

			// 担当者表示リクエスト
			function fncUserShow(autoid)	{
				jQuery("#processing").show();
				jQuery.ajax({
					type: "POST",
					url: "'.$url_base.'data/kanri/user_show",
					data: "autoid=" + autoid,
					success: function(msg){
						jQuery("#processing").hide();
						jQuery("#res_user_edit").html(msg);
						fncShow(\'div_user_edit\', 600, 300);
					},
					error:function(){
						jQuery("#processing").hide();
						alert("通信エラーが発生しました。");
					}
				});
			}

			// 担当者入力チェック
			function fncUserPost(formname)	{
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
					url: "'.$url_base.'data/kanri/user_edit",
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
		$body_title[] .= '担当者検索';
		$body[] .= '
			<form id="form_user_list">
				<table>
					<tr>
						<td style="text-align:right;">担当者ＩＤ</td><td>'.field_text('ser_id', 20, '').'</td>
						<td style="text-align:right;">担当者名</td><td>'.field_text('ser_namae', 20, '').'</td>
					</tr>
					<tr>
						<td colspan="6" style="text-align:right;">
								<input class="button_cancel" type="reset" value="clear" onclick="jQuery(\'#res_user_list\').html(\'\');">&nbsp;&nbsp;
								<input class="button_submit" type="button" value="Search" onclick="fncSerUserList();"">
						</td>
					</tr>
				</table>
			</form>
			<div id="res_user_list" style=""></div>
		';

		// 新規登録表示
		$body_title[] .= '新規担当者';
		$body[] .= '
			<input type=button class="button_save" value="　新しい担当者を登録する" onclick="fncUserShow(\'\');">
			<div id="res_user_edit" style=""></div>
		';

		break;
	case "user_show":
		// 担当者編集（新規）
		$autoid = fnc_getpost('autoid');

		if ($autoid == '')	{
			$title = '【新しいユーザを登録する】';
			$iddata = '<input type="hidden" name="autoid" value="">';
			$cur_namae = '';
			$cur_userid = '';
			$cur_level = '1';
			$cur_inuse = '1';
		}else{
			$title = '【ユーザ情報修正】';
			$iddata = '<input type="hidden" name="autoid" value="'.$autoid.'">';
			try {
				$stt = $db->prepare('SELECT id, namae, userid, level, inuse FROM userlist WHERE id = '.$autoid);
				$stt->execute();
				$idx = 0;
				while($row = $stt->fetch(PDO::FETCH_ASSOC)){
					$idx++;
					$cur_namae = $row['namae'];
					$cur_userid = $row['userid'];
					$cur_level = $row['level'];
					$cur_inuse = $row['inuse'];
				}
			} catch (PDOException $e) {
				die($e->getMessage());
			}
		}
		$level[1] = '';
		$level[5] = '';
		$level[9] = '';
		$level[$cur_level] = ' checked ';

		$msg = '
			<div id="div_user_edit" style="display:none; margin:10px 20px 10px 20px; font-size:10pt; cursor:default;">
				<div style="margin:0 0 10px 0; font-size:12pt; font-weight:bodl;">'.$title.'</dib>
				<form id="form_user_edit">
				<table>
					<tr>
						<td class="label">ユーザＩＤ</td>
						<td class="infield">'.field_required('edit_userid', 20, $cur_userid).'</td>
					</tr>
					<tr>
						<td class="label">ユーザ名</td>
						<td class="infield">'.field_required('edit_namae', 40, $cur_namae).'</td>
					</tr>
					<tr>
						<td class="label">パスワード</td>
		';
		if ($autoid == '')	{
			$msg .= '<td class="infield">'.field_required('edit_userpwd', 20, '').'</td>';
		}else{
			$msg .= '<td class="infield">'.field_text('edit_userpwd', 20, '').'（変更しない場合は、未入力のまま）</td>';
		}
		$msg .= '</tr>
					<tr>
						<td class="label">管理レベル</td>
						<td class="infield">
							<input type=radio name="edit_lvel" value="1"'.$level[1].'>一般ユーザ　
							<input type=radio name="edit_lvel" value="5"'.$level[5].'>管理ユーザ　
							<input type=radio name="edit_lvel" value="9"'.$level[9].'>スーパーバイザー　
						</td>
					</tr>
					<tr>
						<td class="label">使用可否</td>
						<td class="infield"><input type="checkbox" name="edit_inuse"';
		if ($cur_inuse == '1')	{	$msg .= ' checked ';	}
		$msg .= 		'>このユーザは使用可能</td>
					</tr>
					<tr>
						<td colspan="2" style="text-align:right;">
							<input type=button class="button_cancel" value="やめる" onclick="fncHide();">&nbsp;&nbsp;
							<input type=button class="button_submit" value="登録" onclick="fncUserPost(\'form_user_edit\');">
						</td>
					</tr>
				</table>
				'.$iddata.'</form>
			</div>
		';
		$body[] .= $msg;

		break;
	case "user_edit":
		// 担当者情報修正
		$edit_userid = fnc_getpost('edit_userid');
		$edit_namae = fnc_getpost('edit_namae');
		$edit_userpwd = fnc_getpost('edit_userpwd');
		$edit_lvel = fnc_getpost('edit_lvel');
		$edit_inuse = fnc_getpost('edit_inuse');
		if ($edit_inuse == 'on')	{
			$edit_inuse = '1';
		}else{
			$edit_inuse = '0';
		}
		$autoid = fnc_getpost('autoid');

		try {
			// ユーザＩＤ重複確認
			$stt = $db->prepare('SELECT id, userid FROM userlist WHERE id <> "'.$autoid.'" and userid = "'.$edit_userid.'"');
			$stt->execute();
			$idx = 0;
			while($row = $stt->fetch(PDO::FETCH_ASSOC)){
				$idx++;
			}
			if ($idx == 0)	{
				if ($autoid == '')	{
					// 新規登録
					$sql  = 'INSERT INTO userlist (';
					$sql .= ' namae, userid, userpwd, level, inuse, insdate, upddate ';
					$sql .= ') VALUES (';
					$sql .= ' :namae, :userid, :userpwd, :level, :inuse, :insdate, :upddate ';
					$sql .= ')';
					$stt2 = $db->prepare($sql);
					$stt2->bindValue(':namae'	, $edit_namae);
					$stt2->bindValue(':userid'	, $edit_userid);
					$stt2->bindValue(':userpwd'	, md5($edit_userpwd));
					$stt2->bindValue(':level'	, $edit_lvel);
					$stt2->bindValue(':inuse'	, $edit_inuse);
					$stt2->bindValue(':insdate'	, date('Y/m/d H:i:s'));
					$stt2->bindValue(':upddate'	, date('Y/m/d H:i:s'));
					$stt2->execute();
					$arr = array(
						array(
						"result" => "OK",
						"msg"  => "登録しました"
						)
					);
				}else{
					// 既存更新
					$sql  = 'UPDATE userlist SET namae = "'.$edit_namae.'", userid = "'.$edit_userid.'", level = '.$edit_lvel.' , inuse = '.$edit_inuse.', upddate = "'.date('Y/m/d H:i:s').'"';
					if ($edit_userpwd <> '')	{
						$sql .= ' , userpwd = "'.md5($edit_userpwd).'"';
					}
					$sql .= ' WHERE id = '.$autoid;
					$stt = $db->prepare($sql);
					$stt->execute();
					$arr = array(
						array(
						"result" => "OK",
						"msg"  => "更新しました"
						)
					);
				}
			}else{
				// ユーザＩＤ重複
				$arr = array(
					array(
					"result" => "NG",
					"msg"  => "このユーザＩＤは使用されています。"
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

	case "user_ser":
		// 担当者検索

		$ser_id = fnc_getpost('ser_id');
		$ser_namae = fnc_getpost('ser_namae');

		$body_title[] .= '担当者検索結果';
		$msg = '';
		$cond = ' 1=1 ';

		$cond_msg = '[検索条件] ';
		if ($ser_id == '' && $ser_namae == '')	{
			$cond_msg .= 'すべて';
		}else{
			if ($ser_id <> '')	{
				$cond_msg .= '　担当者ＩＤ：'.$ser_id;
				$cond .= ' and userid like "%'.$ser_id.'%"';
			}
			if ($ser_namae <> '')	{
				$cond_msg .= '　担当者名：'.$ser_namae;
				$cond .= ' and namae like "%'.$ser_namae.'%"';
			}
		}

		$msg .= '<table class="listdata">';
		$msg .= '<tr>';
		$msg .= '<th>編集</th>';
		$msg .= '<th width="100">ユーザＩＤ</th>';
		$msg .= '<th width="200">名前</th>';
		$msg .= '<th>権限</th>';
		$msg .= '<th>使用可否</th>';
		$msg .= '</tr>';
		$msg .= '';
		$msg .= '';
		$msg .= '';

		try {
			$stt = $db->prepare('SELECT id, namae, userid, level, inuse FROM userlist WHERE '.$cond.' ORDER BY id');
			$stt->execute();
			$idx = 0;
			while($row = $stt->fetch(PDO::FETCH_ASSOC)){
				$idx++;
				$cur_id = $row['id'];
				$cur_namae = $row['namae'];
				$cur_userid = $row['userid'];
				$cur_level = $row['level'];
				$cur_inuse = $row['inuse'];

				if ($idx % 2 == 0)	{
					$msg .= '<tr>';
				}else{
					$msg .= '<tr class="odd">';
				}
				$msg .= '<td><input type=button class="button_save" value=" 修正" onclick="fncUserShow(\''.$cur_id.'\');"> </td>';
				$msg .= '<td>'.$cur_userid.'</td>';
				$msg .= '<td>'.$cur_namae.'</td>';
				$msg .= '<td>';
				switch ($cur_level)	{
					case '1':
						$msg .= '一般ユーザ';
						break;
					case '5':
						$msg .= '管理ユーザ';
						break;
					case '9':
						$msg .= 'スーパーバイザー';
						break;
				}
				$msg .= '</td>';
				$msg .= '<td>';
				if ($cur_inuse == '1')	{
					$msg .= '&nbsp;';
				}else{
					$msg .= '使用不可';
				}

				$msg .= '</td>';
				$msg .= '</tr>';
			}
		} catch (PDOException $e) {
			die($e->getMessage());
		}
		$msg .= '</table>';
		$body[] .= $cond_msg.'　　[該当件数] '.$idx.'件'.$msg;

		break;

	case "log":
		// 操作ログ

		// ログ操作系ＪＳ
		$script .= '
			// ログ検索
			function fncSerLogList()	{
				jQuery.ajax({
					type: "POST",
					url: "'.$url_base.'data/kanri/log_ser",
					data: jQuery("#form_log_list").serialize(),
					success: function(msg){
						jQuery("#res_log_list").html(msg);
					},
					error:function(){
						alert("通信エラーが発生しました。");
					}
				});
			}
		';

		// 検索画面表示
		$body_title[] .= 'ログ検索';
		$body[] .= '
			<form id="form_log_list">
				<table>
					<tr>
						<td style="text-align:right;">ユーザＩＤ</td><td>'.field_text('ser_id', 20, '').'</td>
						<td style="text-align:right;">操作日時</td><td>'.field_text('ser_date', 20, '').'</td>
					</tr>
					<tr>
						<td colspan="6" style="text-align:right;">
								<input class="button_cancel" type="reset" value="clear" onclick="jQuery(\'#res_log_list\').html(\'\');">&nbsp;&nbsp;
								<input class="button_submit" type="button" value="Search" onclick="fncSerLogList();"">
						</td>
					</tr>
				</table>
			</form>
			<div id="res_log_list" style=""></div>
		';
		break;
	case "log_ser":
		// ログ検索

		$ser_id = fnc_getpost('ser_id');
		$ser_date = fnc_getpost('ser_date');

		$body_title[] .= 'ログ検索結果';
		$msg = '';
		$cond = ' 1=1 ';

		$cond_msg = '[検索条件] ';
		if ($ser_id == '' && $ser_date == '')	{
			$cond_msg .= 'すべて';
		}else{
			if ($ser_id <> '')	{
				$cond_msg .= '　ユーザＩＤ：'.$ser_id;
				$cond .= ' and user_id like "%'.$ser_id.'%"';
			}
			if ($ser_date <> '')	{
				$cond_msg .= '　操作日：'.$ser_date;
				$cond .= ' and log_date <= "'.$ser_date.'"';
			}
		}

		$msg .= '<table class="listdata">';
		$msg .= '<tr>';
		$msg .= '<th with="120">操作時刻</th>';
		$msg .= '<th with="120">ユーザ</th>';
		$msg .= '<th>リクエスト</th>';
		$msg .= '<th>リモートＩＰ</th>';
		$msg .= '</tr>';
		$msg .= '';
		$msg .= '';
		$msg .= '';

		try {
			$stt = $db->prepare('SELECT id, log_date, user_id, user_name, request_uri, request_method, remote_addr FROM log WHERE '.$cond.' ORDER BY id desc');
			$stt->execute();
			$idx = 0;
			while($row = $stt->fetch(PDO::FETCH_ASSOC)){
				$idx++;
				if ($idx % 2 == 0)	{
					$msg .= '<tr>';
				}else{
					$msg .= '<tr class="odd">';
				}
				$msg .= '<td>'.$row['log_date'].'</td>';
				$msg .= '<td>'.$row['user_id'].'</td>';
				$msg .= '<td>('.$row['request_method'].')'.$row['request_uri'].'</td>';
				$msg .= '<td>'.$row['remote_addr'].'</td>';
				$msg .= '</tr>';
				if ($idx >= 100)	{
					break;
				}
			}
		} catch (PDOException $e) {
			die($e->getMessage());
		}
		$msg .= '</table>';
		$body[] .= $cond_msg.'　　[該当件数] '.$idx.'件'.$msg;

		break;
}


?>