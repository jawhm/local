<?php

// 一般メニュー読み込み
require 'php/fnc_menu.php';

if (count($param) > 2) {
    $data_param = $param[2];
} else {
    $data_param = 'main';
}

switch ($data_param) {
    case "main":
        // メールテンプレート
        // 操作系ＪＳ
        $script .= '
			// 表示リクエスト
			function fnctempShow(obj) {
                            var keycd = jQuery(obj).data("mid");
                            jQuery("#processing").show();
                                jQuery.ajax({
                                    type: "POST",
                                    url: "' . $url_base . 'data/mailtempsign/show",
                                    data: "keycd=" + keycd,
                                    success: function(msg){
                                            jQuery("#processing").hide();
                                            jQuery("#res_mailtemp_edit").html(msg);
                                            fncShow(\'div_mailtemp_edit\', 800, 600);
                                            if (fl_trigger==true){
                                                jQuery("#edit_text5").trigger("change");
                                                fl_trigger = false;
                                            }
                                            //
                                            if (isNaN(keycd)) {
                                                jQuery("#edit_text5").attr("disabled", false);
                                            }else{
                                                var area = jQuery("#edit_text5 option:selected").text();
                                                jQuery("#edit_text5").css("display", "none");
                                                jQuery("#edit_text5").parent().append("<p>"+area+"</p>");
                                            }
                                    },
                                    error:function(){
                                            jQuery("#processing").hide();
                                            alert("通信エラーが発生しました。");
                                    }
                                });
			}
                        
			function fncsendmailShow() {
                            jQuery("#processing").show();
                                jQuery.ajax({
                                    type: "POST",
                                    url: "' . $url_base . 'data/mailtempsign/showtestmail",
                                    success: function(msg){
                                            jQuery("#processing").hide();
                                            jQuery("#res_mailtemp_edit").html(msg);
                                            fncShow(\'div_mailtemp_edit\', 650, 600);
                                            jQuery("#edit_text5").trigger("change");
                                    },
                                    error:function(){
                                            jQuery("#processing").hide();
                                            alert("通信エラーが発生しました。");
                                    }
                                });
			}
                        
                        var cur_area = "";
                        function fncSelect(obj){
                            cur_area = jQuery(obj).val();
                        }
                        
                        function fncLoad(obj){
                            var cnfm = true;
                            var area = jQuery(obj).val();
                            if (fl_trigger != true){
                                cnfm = confirm("所属エリアを変更すると\n編集内容が破棄されますがよろしいですか?");
                            }
                            //
                            if (cnfm == true){
                                jQuery.ajax({
                                    type: "POST",
                                    url: "' . $url_base . 'data/mailtempsign/load",
                                    data: "area=" + area,
                                    success: function(msg){
                                        res = jQuery.parseJSON(msg);
                                        if (res.msg == "EMPTY"){
                                            jQuery("#edit_keycd").val("create");
                                            jQuery("#form_mailtemp_edit").find("input[type=text], textarea").val("");
                                            jQuery("#edit_text1").focus();
                                        }else{
                                            jQuery("#edit_keycd").val(res.msg.id);
                                            jQuery("#edit_text1").val(res.msg.text1);
                                            jQuery("#edit_text3").val(res.msg.text3);
                                            jQuery("#edit_text4").val(res.msg.text4);
                                        }
                                    }
                                });
                            }else{
                                jQuery("#edit_text5").val(cur_area);
                            }
                        }

			// 入力チェック
                        function fncPost(formname){
                            //jQuery("#" + formname).validate({
                                //rules: {
                                //    edit_text1: "required",
                                //    edit_text3: "required",
                                //},
                                //messages: {
                                //    edit_text1: "署名テンプレート名を入力してください",
                                //    edit_text3: "署名を入力してください",
                                //},
                                //submitHandler: function(){
                                    document.getElementById("mailtempsubmit").value = "Wait";
                                    document.getElementById("mailtempsubmit").disabled = true;
                                    jQuery("#processing").show();
                                    jQuery.ajax({
                                        type: "POST",
                                        url: "' . $url_base . 'data/mailtempsign/edit",
                                        data: jQuery("#" + formname).serialize(),
                                        success: function(msg){
                                            jQuery("#processing").hide();
                                            res = eval(msg);
                                            alert(res[0].msg);
                                            if (res[0].result == \'OK\')	{
                                                    jQuery.unblockUI();
                                                    window.location.reload();
                                            }
                                            //
                                            fl_trigger = true;
                                        },
                                        error:function(){
                                                jQuery("#processing").hide();
                                                alert("通信エラーが発生しました。");
                                        }
                                    });
                                    //return false;
                                //}
                            //});
			}
                        
                        // テストメール送信
                        function fncSendmailPost(formname){
                            jQuery("#" + formname).validate({
                                rules: {
                                    email: {
                                        required: true,
                                        email: true
                                    }
                                },
                                messages: {
                                    email: {
                                        required: "宛先メールアドレスを入力してください",
                                        email: "無効なメール"
                                    }
                                },
                                submitHandler: function(){
                                    document.getElementById("mailtempsubmit").value = "Wait";
                                    document.getElementById("mailtempsubmit").disabled = true;
                                    jQuery("#processing").show();
                                    jQuery.ajax({
                                            type: "POST",
                                            url: "' . $url_base . 'data/mailtempsign/sendmail",
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
                                    return false;
                                }
                            });
			}
		';


        try {
            $sql = "SELECT * FROM mailtext WHERE keycd LIKE 'mail_sign' ORDER BY text5";
            $stt = $db->prepare($sql);
            $stt->execute();
            $idx = 0;
            $table_mail_temp_data = '<table class="list-data"><tr>'
                    . '<th>No.</th>'
                    . '<th>所属エリア</th>'
                    . '<th>署名タイトル</th>'
                    . '<th>更新日時</th>'
                    . '<th>編集</th>'
                    . '</tr>';
            
            while ($row = $stt->fetch(PDO::FETCH_ASSOC)) {
                $idx++;
                $table_mail_temp_data .= '<tr>';
                $table_mail_temp_data .= '<td align="center">' . $idx . '</td>';
                $table_mail_temp_data .= '<td>' . item_alias('area', $row['text5']) . '</td>';
                $table_mail_temp_data .= '<td>' . stripslashes($row['text1']) . '</td>';
                $table_mail_temp_data .= '<td align="center">' . $row['date_modified'] . '</td>';
                $table_mail_temp_data .= '<td align="center"><a href="javascript:void(0)" data-mid="' . $row['id'] . '" onclick="fnctempShow(this);">編集</a></td>';
                $table_mail_temp_data .= '</tr>';
            }
            $table_mail_temp_data .= '</table>';
        } catch (PDOException $e) {
            die($e->getMessage());
        }


        // 検索画面表示
        $body_title[] .= 'メールテンプレート設定　（署名）';
        $body[] .= '
			<a href="javascript:void(0);" data-mid="create" onclick="fnctempShow(this);">テンプレートメール（署名）新規登録</a><br/>
			&nbsp;<br/>
			<a href="javascript:void(0);" onclick="fncsendmailShow();">テストメール送信</a><br/>
			&nbsp;<br/>
                        <h3>【テンプレートメール（署名）一覧】</h3>'
                . $table_mail_temp_data
                . ' <div id="res_mailtemp_edit" style=""></div> ';

        break;

    case "show":
        // メールテンプレート表示
        $cur_keycd = fnc_getpost('keycd');

        $list_area = item_alias('area');

        if (is_string($cur_keycd) && $cur_keycd == 'create') {
            $title = '【メールテンプレート登録】';
            $cur_text1 = '';
            $cur_text5 = '';
            $cur_text3 = '';
            $cur_text4 = '';
        } else {
            $title = '【メールテンプレート修正】';
            try {
                $stt = $db->prepare('SELECT text1, text2, text3, text4, text5 FROM mailtext WHERE id = "' . $cur_keycd . '"');
                $stt->execute();
                $idx = 0;
                while ($row = $stt->fetch(PDO::FETCH_ASSOC)) {
                    $idx++;
                    $cur_text1 = stripslashes($row['text1']);     // 署名テンプレート名
                    $cur_text5 = stripslashes($row['text5']);     // 所属エリア
                    $cur_text3 = stripslashes($row['text3']);     // 署名
                    $cur_text4 = stripslashes($row['text4']);     // 備考・メモ
                }
            } catch (PDOException $e) {
                die($e->getMessage());
            }
        }
        
        $msg = '
            <div id="div_mailtemp_edit" style="display:none; margin:10px 20px 10px 20px; font-size:10pt; cursor:default;">
                <div style="margin:0 0 10px 0; font-size:10pt; font-weight:bold;">' . $title . '</dib>
                <form id="form_mailtemp_edit">
                    <input type="hidden" id="edit_keycd" name="edit_keycd" value="' . $cur_keycd . '">
                    <table style="font-size:10pt;">
                        <tr>
                            <td class="label">所属エリア</td>
                            <td class="infield">' . dropdown_list('edit_text5', $cur_text5, $list_area, array('onchange' => 'fncLoad(this)', 'onclick' => 'fncSelect(this)')) . '</td>
                            <td>設定するエリアを選択してください</td>
                        </tr>
                        <tr>
                            <td class="label" width="120">署名テンプレート名</td>
                            <td class="infield" width="500">' . field_text('edit_text1', 50, $cur_text1) . '</td>
                            <td>テンプレート名を入力してください</td>
                        </tr>
                        <tr>
                            <td class="label">署名</td>
                            <td class="infield">
                                <textarea id="edit_text3" name="edit_text3" cols="60" rows="10" style="font-size:10pt">' . $cur_text3 . '</textarea>
                            </td>
                            <td>署名の本文を入力してください</td>
                        </tr>
                        <tr>
                            <td class="label">備考・メモ</td>
                            <td class="infield">
                                <textarea id="edit_text4" name="edit_text4" cols="60" rows="2" style="font-size:10pt">' . $cur_text4 . '</textarea>
                            </td>
                            <td>備考・メモ欄は送信メールに記述されません</td>
                        </tr>
                        <tr>
                            <td colspan="2" style="text-align:right;">
                                <input type=button class="button_cancel" value="やめる" onclick="fncHide();">&nbsp;&nbsp;
                                <input type=submit class="button_submit" value="登録" id="mailtempsubmit" onclick="fncPost(\'form_mailtemp_edit\');">
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
		';
        $body[] .= $msg;
        break;

    case "showtestmail":
        //
        $title = '【テストメール送信】';
        // メールテンプレート
        try {
            $stt = $db->prepare('SELECT id, text1, text2, text3, text4, text5 FROM mailtext WHERE keycd = "mail_temp"');
            $stt->execute();
            $mail_temp = array();
            while ($row = $stt->fetch(PDO::FETCH_ASSOC)) {
                $id = $row['id'];
                $mail_temp[$id] = $row['text1'];     // テンプレート名
            }
        } catch (PDOException $e) {
            die($e->getMessage());
        }
        // メールテンプレート(署名)
        try {
            $stt = $db->prepare('SELECT id, text1, text2, text3, text4, text5 FROM mailtext WHERE keycd = "mail_sign"');
            $stt->execute();
            $mail_sign = array();
            while ($row = $stt->fetch(PDO::FETCH_ASSOC)) {
                $id = $row['id'];
                $mail_sign[$id] = $row['text1'];     // 署名テンプレート名
            }
        } catch (PDOException $e) {
            die($e->getMessage());
        }

        $msg = '
            <div id="div_mailtemp_edit" style="display:none; margin:10px 20px 10px 20px; font-size:10pt; cursor:default;">
                    <div style="margin:0 0 10px 0; font-size:10pt; font-weight:bold;">' . $title . '</dib>
                    <form id="form_test_mail">
                    <table style="font-size:10pt;">
                            <tr>
                                <td class="label" width="200">宛先メールアドレス</td>
                                <td class="infield" width="500">
                                    <input type="text" id="email" name="email" placeholder="example@domain"/>
                                </td>
                            </tr>
                            <tr>
                                <td class="label">使用メールテンプレート</td>
                                <td class="infield">' . dropdown_list('tempid', '', $mail_temp) . '</td>
                            </tr>
                            <tr>
                                <td class="label">メールテンプレート(署名)</td>
                                <td class="infield">' . dropdown_list('signid', '', $mail_sign) . '</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="text-align:right;">
                                    <input type=button class="button_cancel" value="やめる" onclick="fncHide();">&nbsp;&nbsp;
                                    <input type=submit class="button_submit" value="送信" id="mailtempsubmit" onclick="fncSendmailPost(\'form_test_mail\');">
                                </td>
                            </tr>
                    </table>
                    </form>
            </div>
		';
        $body[] .= $msg;
        break;

    case "sendmail":
        $email = fnc_getpost('email');
        $tempid = fnc_getpost('tempid');
        $signid = fnc_getpost('signid');
        $subject = '';
        $mail_body = '';
        $mail_sign = '';

        // メールテンプレート
        try {
            $stt = $db->prepare('SELECT id, text1, text2, text3, text4, text5 FROM mailtext WHERE keycd = "mail_temp" AND id=' . (int) $tempid);
            $stt->execute();
            while ($row = $stt->fetch(PDO::FETCH_ASSOC)) {
                $mail_body = stripslashes($row['text3']);
                $subject = stripslashes($row['text2']);
            }
        } catch (PDOException $e) {
            die($e->getMessage());
        }
        // メールテンプレート(署名)
        try {
            $stt = $db->prepare('SELECT id, text1, text2, text3, text4, text5 FROM mailtext WHERE keycd = "mail_sign" AND id=' . (int) $signid);
            $stt->execute();
            while ($row = $stt->fetch(PDO::FETCH_ASSOC)) {
                $mail_sign = stripslashes($row['text3']);     // 署名テンプレート名
            }
        } catch (PDOException $e) {
            die($e->getMessage());
        }
        
        //
        $stt2 = $db->prepare('SELECT '
                . ' ev.id AS seminar_id , namae AS subscriber_name,  hiduke AS seminar_date, year(hiduke) as y, month(hiduke) as m, day(hiduke) as d, date_format(hiduke,\'%w\') as yobi, t_title1 AS seminar_title, et.id AS booking_num '
                . ' FROM event_list ev '
                . ' JOIN entrylist et ON (ev.id = seminarid) '
                . ' LIMIT 1 ');
        $stt2->execute();
        
        $data_s = array();
        while ($row = $stt2->fetch(PDO::FETCH_ASSOC)) {
            $data_s = array(
                'subscriber_name' => $row['subscriber_name'],
                'seminar_id' => $row['seminar_id'],
                'seminar_date' => $row['seminar_date'],
                'seminar_title' => $row['seminar_title'],
                'booking_num' => $row['booking_num'],
            );
        }
        
        require_once '../../lib/TemplateFile.php';
        
        $mail_body = new TemplateFile($mail_body, $data_s);
        
        $data = array(
            'body' => $mail_body,
            'sign' => $mail_sign
        );
        
        $mail_content = new TemplateFile('../tpl/testemail.tpl', $data);
        
        $subject = $mail_body->getSubject($subject);
        $from = mb_encode_mimeheader(mb_convert_encoding("日本ワーキングホリデー協会", "JIS")) . "<sodan@jawhm.or.jp>";
        //
        if (mb_send_mail($email, $subject, $mail_content, "From:" . $from)){
            $arr = array(
                array(
                    "result" => "OK",
                    "msg" => "送信しました"
                )
            );
        } else{
            $arr = array(
                array(
                    "result" => "NG",
                    "msg" => "通信エラーしました"
                )
            );
        }

        $msg = json_encode($arr);
        $body[] .= $msg;
        break;

    case "load":

        $area = fnc_getpost('area');

        try {

            $sql = "SELECT * FROM mailtext WHERE keycd LIKE 'mail_sign' AND text5 LIKE '$area'";
            $stt = $db->prepare($sql);
            $stt->execute();
            $msg = array();
            while ($row = $stt->fetch(PDO::FETCH_ASSOC)) {
                $msg['id'] = $row['id'];
                $msg['text1'] = stripslashes($row['text1']);
                $msg['text5'] = stripslashes($row['text5']);
                $msg['text3'] = stripslashes($row['text3']);
                $msg['text4'] = stripslashes($row['text4']);
            }

            if ($msg != NULL) {
                $msg = json_encode(array("msg" => $msg));
            } else {
                $msg = json_encode(array("msg" => "EMPTY"));
            }
        } catch (PDOException $e) {
            die($e->getMessage());
        }

        $body[] .= $msg;

        break;

    case "edit":

        $edit_keycd = fnc_getpost('edit_keycd');
        $edit_text1 = addslashes(fnc_getpost('edit_text1'));
        $edit_text5 = addslashes(fnc_getpost('edit_text5'));
        $edit_text3 = addslashes(fnc_getpost('edit_text3'));
        $edit_text4 = addslashes(fnc_getpost('edit_text4'));

        if (is_string($edit_keycd) && $edit_keycd == 'create') {

            // メールテンプレート作成
            try {
                // 既存更新
                $sql = "INSERT INTO mailtext ( keycd, text1, text5, text3, text4, date_created, date_modified) ";
                $sql .= "  VALUES ( ";
                $sql .= "'mail_sign', '$edit_text1', '$edit_text5', '$edit_text3', '$edit_text4', NOW(), NOW() )";
                $stt = $db->prepare($sql);
                $stt->execute();
                $arr = array(
                    array(
                        "result" => "OK",
                        "msg" => "更新しました"
                    )
                );
            } catch (PDOException $e) {
                $arr = array(
                    array(
                        "result" => "NG",
                        "msg" => $e->getMessage()
                    )
                );
            }
        } else {

            // メールテンプレート修正
            try {
                // 既存更新
                $sql = 'UPDATE mailtext SET ';
                $sql .= '  text1 = :text1 ';
                $sql .= ', text5 = :text5 ';
                $sql .= ', text3 = :text3 ';
                $sql .= ', text4 = :text4 ';
                $sql .= ', date_modified = NOW() ';
                $sql .= ' WHERE id = "' . $edit_keycd . '"';
                $stt = $db->prepare($sql);
                $stt->bindValue(':text1', $edit_text1);
                $stt->bindValue(':text5', $edit_text5);
                $stt->bindValue(':text3', $edit_text3);
                $stt->bindValue(':text4', $edit_text4);
                $stt->execute();
                $arr = array(
                    array(
                        "result" => "OK",
                        "msg" => "更新しました"
                    )
                );
            } catch (PDOException $e) {
                $arr = array(
                    array(
                        "result" => "NG",
                        "msg" => $e->getMessage()
                    )
                );
            }
        }

        $msg = json_encode($arr);
        $body[] .= $msg;
        break;
}
?>