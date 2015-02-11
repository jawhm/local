<?php

header('Content-Type: text/html; charset=utf-8');
mb_language("Ja");
mb_internal_encoding("utf8");

ini_set("display_errors", "On");

msgout('開始');
require_once 'googleapi.php';
require_once '../lib/TemplateFile.php';

// ＤＢ接続
$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);

// 仮予約キャンセル
msgout('----- 仮予約キャンセル -----');
try {
    $db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->query('SET CHARACTER SET utf8');
    $stt = $db->prepare('SELECT id, seminarid, namae, furigana, tel, email, ninzu, stat, wait, mailstat FROM entrylist WHERE ( stat = "0" or stat = "3" ) and wait = "0" and upddate <= date_sub(now(), interval "0 24" day_hour )');
    $stt->execute();
    $idx = 0;
    while ($row = $stt->fetch(PDO::FETCH_ASSOC)) {
        // 予約情報読み込み
        $idx++;
        $cur_yoyakuid = $row['id'];
        $cur_seminarid = $row['seminarid'];
        $cur_namae = $row['namae'];
        $cur_furigana = $row['furigana'];
        $cur_tel = $row['tel'];
        $cur_email = $row['email'];
        $cur_ninzu = $row['ninzu'];
        $cur_stat = $row['stat'];
        $cur_wait = $row['wait'];
        $cur_mailstat = $row['mailstat'];

        $db2 = new PDO($ini['dsn'], $ini['user'], $ini['password']);
        $db2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db2->query('SET CHARACTER SET utf8');
        $stt2 = $db2->prepare('SELECT id, place, hiduke, year(hiduke) as y, month(hiduke) as m, day(hiduke) as d, date_format(hiduke,\'%w\') as yobi, date_format(starttime,\'%k:%i\') as sttime, k_title1, k_desc1, pax, booking, waitting FROM event_list WHERE id = "' . $cur_seminarid . '"');
        $stt2->execute();
        while ($row2 = $stt2->fetch(PDO::FETCH_ASSOC)) {
            // イベント情報読み込み
            $cur_id = $row2['id'];
            $cur_place = $row2['place'];
            $cur_hiduke = $row2['hiduke'];
            $cur_y = $row2['y'];
            $cur_m = $row2['m'];
            $cur_d = $row2['d'];
            $cur_yobi = $row2['yobi'];
            $cur_sttime = $row2['sttime'];
            $cur_title1 = $row2['k_title1'];
            $cur_desc1 = $row2['k_desc1'];
            $cur_pax = $row2['pax'];
            $cur_booking = $row2['booking'];
            $cur_waitting = $row2['waitting'];
        }

        // 予約状況変更
        $sql = 'UPDATE entrylist SET ';
        $sql .= '  stat = "5"';
        $sql .= ' ,upddate = "' . date('Y/m/d H:i:s') . '"';
        $sql .= ' WHERE id = "' . $cur_yoyakuid . '"';
        $stt2 = $db2->prepare($sql);
        $stt2->execute();

        // 席数変更
        $sql = 'UPDATE event_list SET booking = booking - ' . $cur_ninzu . ' WHERE id = ' . $cur_seminarid;
        $stt2 = $db2->prepare($sql);
        $stt2->execute();

        // メール送信
        $subject = '仮予約キャンセルのお知らせ';
        $body1 = '';
        $body1 .= 'ご予約頂きました以下のイベント（セミナー）ですが、ご予約の確定が行われませんでしたのでキャンセルとさせて頂きます。';
        $body1 .= chr(10);
        $body1 .= 'イベント（セミナー）にご出席希望の場合は、お手数ですが再度のご予約をお願いいたします。';
        $body2 = '';
        sendmail($subject, $body1, $body2, $cur_namae, $cur_place, $cur_y, $cur_m, $cur_d, $cur_yobi, $cur_sttime, $cur_title1, $cur_yoyakuid, $cur_email, $cur_desc1);

        // カレンダー変更
        GC_Edit($cur_seminarid);

        msgout('予約番号：' . $cur_yoyakuid . '　セミナー：' . $cur_title1);

        $db2 = NULL;
    }
    $db = NULL;
} catch (PDOException $e) {
    msgout($e->getMessage());
}


// キャンセル待ち処理
msgout('----- キャンセル待ち処理 -----');
try {
    $db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->query('SET CHARACTER SET utf8');
    $stt = $db->prepare('SELECT id, seminarid, namae, furigana, tel, email, ninzu, stat, wait, mailstat FROM entrylist WHERE ( stat = "0" or stat = "3" ) and wait = "1" ORDER BY id');
    $stt->execute();
    $idx = 0;
    while ($row = $stt->fetch(PDO::FETCH_ASSOC)) {
        // 予約情報読み込み
        $idx++;
        $cur_yoyakuid = $row['id'];
        $cur_seminarid = $row['seminarid'];
        $cur_namae = $row['namae'];
        $cur_furigana = $row['furigana'];
        $cur_tel = $row['tel'];
        $cur_email = $row['email'];
        $cur_ninzu = $row['ninzu'];
        $cur_stat = $row['stat'];
        $cur_wait = $row['wait'];
        $cur_mailstat = $row['mailstat'];

        $db2 = new PDO($ini['dsn'], $ini['user'], $ini['password']);
        $db2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db2->query('SET CHARACTER SET utf8');
        $stt2 = $db2->prepare('SELECT id, place, hiduke, year(hiduke) as y, month(hiduke) as m, day(hiduke) as d, date_format(hiduke,\'%w\') as yobi, date_format(starttime,\'%k:%i\') as sttime, k_title1, k_desc1, pax, booking, waitting FROM event_list WHERE starttime >= date_add(now(), interval "0 2" day_hour ) and id = "' . $cur_seminarid . '"');
        $stt2->execute();
        $cur_pax = 0;
        $cur_booking = 0;
        $cur_id = '';
        $cur_title1 = '';
        while ($row2 = $stt2->fetch(PDO::FETCH_ASSOC)) {
            // イベント情報読み込み
            $cur_id = $row2['id'];
            $cur_place = $row2['place'];
            $cur_hiduke = $row2['hiduke'];
            $cur_y = $row2['y'];
            $cur_m = $row2['m'];
            $cur_d = $row2['d'];
            $cur_yobi = $row2['yobi'];
            $cur_sttime = $row2['sttime'];
            $cur_title1 = $row2['k_title1'];
            $cur_desc1 = $row2['k_desc1'];
            $cur_pax = $row2['pax'];
            $cur_booking = $row2['booking'];
            $cur_waitting = $row2['waitting'];
        }

        if ($cur_id == '') {
            msgout("キャンセル待ち削除対象情報：" . $cur_yoyakuid . " - " . $cur_namae . " / " . $cur_id . " - " . $cur_title1);

            // 予約状況変更
            $sql = 'UPDATE entrylist SET ';
            $sql .= '  wait = "0"';
            $sql .= ' ,stat = "6"';
            $sql .= ' ,upddate = "' . date('Y/m/d H:i:s') . '"';
            $sql .= ' WHERE id = "' . $cur_yoyakuid . '"';
            $stt2 = $db2->prepare($sql);
            $stt2->execute();
        } else {

            $aki = $cur_pax - $cur_booking;
            msgout("予約者情報：" . $cur_yoyakuid . " - " . $cur_namae . " / " . $cur_id . " - " . $cur_y . "-" . $cur_m . "-" . $cur_d . " " . $cur_title1);

            if ($aki >= $cur_ninzu) {

                msgout("予約可能");

                // 予約状況変更
                $sql = 'UPDATE entrylist SET ';
                $sql .= '  wait = "0"';
                $sql .= ' ,upddate = "' . date('Y/m/d H:i:s') . '"';
                $sql .= ' WHERE id = "' . $cur_yoyakuid . '"';
                $stt2 = $db2->prepare($sql);
                $stt2->execute();

                // 席数変更
                $sql = 'UPDATE event_list SET booking = booking + ' . $cur_ninzu . ' , waitting = waitting - ' . $cur_ninzu . ' WHERE id = ' . $cur_seminarid;
                $stt2 = $db2->prepare($sql);
                $stt2->execute();

                // メール送信
                $subject = '仮予約のお知らせ';
                $body1 = '';
                $body1 .= 'ご予約頂きました以下のイベント（セミナー）ですが、空きが出来ましたのでお席の用意が出来る状態となりました。';
                $body1 .= chr(10);
                $body1 .= 'なお、現在は「仮予約」の状態ですので以下のURLを表示し、必ずご予約を確定させてください。';
                $body1 .= chr(10);
                $body1 .= 'また、ご予約が確定されない場合、２４時間で自動的にこの仮予約はキャンセルされます。ご注意ください。';
                $body2 = '';
                sendmail($subject, $body1, $body2, $cur_namae, $cur_place, $cur_y, $cur_m, $cur_d, $cur_yobi, $cur_sttime, $cur_title1, $cur_yoyakuid, $cur_email, $cur_desc1);

                msgout('予約番号：' . $cur_yoyakuid . '　セミナー：' . $cur_title1);

                // カレンダー変更
                GC_Edit($cur_seminarid);
            }
        }
        $db2 = NULL;
    }
    $db = NULL;
} catch (PDOException $e) {
    msgout($e->getMessage());
}

// 前日メール
if (date('H') == 18) {
    msgout('----- 前日メール -----');

    try {
        $db3 = new PDO($ini['dsn'], $ini['user'], $ini['password']);
        $db3->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db3->query('SET CHARACTER SET utf8');

        $db2 = new PDO($ini['dsn'], $ini['user'], $ini['password']);
        $db2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db2->query('SET CHARACTER SET utf8');
        $stt2 = $db2->prepare('SELECT id, place, hiduke, year(hiduke) as y, month(hiduke) as m, day(hiduke) as d, date_format(hiduke,\'%w\') as yobi, date_format(starttime,\'%k:%i\') as sttime, k_title1, k_desc1, pax, booking, waitting, mailinfo FROM event_list WHERE hiduke = date_add(current_date(), INTERVAL 1 DAY) ');
        $stt2->execute();
        while ($row2 = $stt2->fetch(PDO::FETCH_ASSOC)) {
            // イベント情報読み込み
            $cur_id = $row2['id'];
            $cur_place = $row2['place'];
            $cur_hiduke = $row2['hiduke'];
            $cur_y = $row2['y'];
            $cur_m = $row2['m'];
            $cur_d = $row2['d'];
            $cur_yobi = $row2['yobi'];
            $cur_sttime = $row2['sttime'];
            $cur_title1 = $row2['k_title1'];
            $cur_desc1 = $row2['k_desc1'];
            $cur_pax = $row2['pax'];
            $cur_booking = $row2['booking'];
            $cur_waitting = $row2['waitting'];
            $cur_mailinfo = $row2['mailinfo'];

            $db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $db->query('SET CHARACTER SET utf8');
            $stt = $db->prepare('SELECT id, seminarid, namae, furigana, tel, email, ninzu, stat, wait, mailstat FROM entrylist WHERE stat = "1" and wait = "0" and mailstat = "0" and seminarid = "' . $cur_id . '" ORDER BY id');
            $stt->execute();
            $idx = 0;
            while ($row = $stt->fetch(PDO::FETCH_ASSOC)) {
                // 予約情報読み込み
                $idx++;
                $cur_yoyakuid = $row['id'];
                $cur_seminarid = $row['seminarid'];
                $cur_namae = $row['namae'];
                $cur_furigana = $row['furigana'];
                $cur_tel = $row['tel'];
                $cur_email = $row['email'];
                $cur_ninzu = $row['ninzu'];
                $cur_stat = $row['stat'];
                $cur_wait = $row['wait'];
                $cur_mailstat = $row['mailstat'];

                // メール送信状況変更
                $sql = 'UPDATE entrylist SET ';
                $sql .= '  mailstat = "1"';
                $sql .= ' ,upddate = "' . date('Y/m/d H:i:s') . '"';
                $sql .= ' WHERE id = "' . $cur_yoyakuid . '"';
                $stt3 = $db3->prepare($sql);
                $stt3->execute();

                // メール送信
                $subject = '明日のイベント（セミナー）のお知らせ';
                $body1 = '';
                $body1 .= 'ご予約頂きました以下のイベント（セミナー）が明日開催されますが、ご都合はいかがでしょうか？';
                $body1 .= chr(10);
                $body1 .= '１５分前に開場となりますので、５分前までにはご来場頂けますようお願い申し上げます。';
                $body1 .= chr(10);
                $body1 .= 'イベント（セミナー）の定刻開始にご協力をお願い致します。';
                $body1 .= chr(10);
                $body1 .= chr(10);
                $body1 .= $cur_mailinfo;
                $body1 .= chr(10);
                $body1 .= 'なお、ご都合がつかない場合は、以下のURLより予約のキャンセルをお願い致します。';
                $body2 = 'それでは、明日お会いできます事を楽しみにしております。お気をつけてご来場ください。';
                sendmail($subject, $body1, $body2, $cur_namae, $cur_place, $cur_y, $cur_m, $cur_d, $cur_yobi, $cur_sttime, $cur_title1, $cur_yoyakuid, $cur_email, $cur_desc1);

                msgout('予約番号：' . $cur_yoyakuid . '　セミナー：' . $cur_title1);
            }
            $db = NULL;
        }
        $db2 = NULL;
        $db3 = NULL;
    } catch (PDOException $e) {
        msgout($e->getMessage());
    }
}

// 直前メール
msgout('----- 直前メール -----');

try {
    $db3 = new PDO($ini['dsn'], $ini['user'], $ini['password']);
    $db3->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db3->query('SET CHARACTER SET utf8');

    $db2 = new PDO($ini['dsn'], $ini['user'], $ini['password']);
    $db2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db2->query('SET CHARACTER SET utf8');
    $stt2 = $db2->prepare('SELECT id, place, hiduke, year(hiduke) as y, month(hiduke) as m, day(hiduke) as d, date_format(hiduke,\'%w\') as yobi, date_format(starttime,\'%k:%i\') as sttime, k_title1, k_desc1, pax, booking, waitting FROM event_list WHERE starttime <= date_add(now(), interval "0 1" day_hour ) and starttime >= date_sub(now(), interval "3 0" day_hour ) ');
    $stt2->execute();
    while ($row2 = $stt2->fetch(PDO::FETCH_ASSOC)) {
        // イベント情報読み込み
        $cur_id = $row2['id'];
        $cur_place = $row2['place'];
        $cur_hiduke = $row2['hiduke'];
        $cur_y = $row2['y'];
        $cur_m = $row2['m'];
        $cur_d = $row2['d'];
        $cur_yobi = $row2['yobi'];
        $cur_sttime = $row2['sttime'];
        $cur_title1 = $row2['k_title1'];
        $cur_desc1 = $row2['k_desc1'];
        $cur_pax = $row2['pax'];
        $cur_booking = $row2['booking'];
        $cur_waitting = $row2['waitting'];

        $db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->query('SET CHARACTER SET utf8');
        $stt = $db->prepare('SELECT id, seminarid, namae, furigana, tel, email, ninzu, stat, wait, mailstat FROM entrylist WHERE stat = "1" and wait = "0" and ( mailstat = "0" or mailstat = "1" ) and seminarid = "' . $cur_id . '" ORDER BY id');
        $stt->execute();
        $idx = 0;
        while ($row = $stt->fetch(PDO::FETCH_ASSOC)) {
            // 予約情報読み込み
            $idx++;
            $cur_yoyakuid = $row['id'];
            $cur_seminarid = $row['seminarid'];
            $cur_namae = $row['namae'];
            $cur_furigana = $row['furigana'];
            $cur_tel = $row['tel'];
            $cur_email = $row['email'];
            $cur_ninzu = $row['ninzu'];
            $cur_stat = $row['stat'];
            $cur_wait = $row['wait'];
            $cur_mailstat = $row['mailstat'];

            // メール送信状況変更
            $sql = 'UPDATE entrylist SET ';
            $sql .= '  mailstat = "2"';
            $sql .= ' ,upddate = "' . date('Y/m/d H:i:s') . '"';
            $sql .= ' WHERE id = "' . $cur_yoyakuid . '"';
            $stt3 = $db3->prepare($sql);
            $stt3->execute();

            // メール送信
            $subject = '本日のイベント（セミナー）のお知らせ';
            $body1 = '';
            $body1 .= 'ご予約頂きました以下のイベント（セミナー）がまもなく開催されます。';
            $body1 .= chr(10);
            $body1 .= '１５分前に開場となりますので、５分前までにはご来場頂けますようお願い申し上げます。';
            $body1 .= chr(10);
            $body1 .= 'イベント（セミナー）の定刻開始にご協力をお願い致します。';
            $body1 .= chr(10);
            $body2 = 'どうぞお気をつけてご来場ください。';
            sendmail($subject, $body1, $body2, $cur_namae, $cur_place, $cur_y, $cur_m, $cur_d, $cur_yobi, $cur_sttime, $cur_title1, $cur_yoyakuid, $cur_email, $cur_desc1);

            msgout('予約番号：' . $cur_yoyakuid . '　セミナー：' . $cur_title1);
        }
        $db = NULL;
    }
    $db2 = NULL;
    $db3 = NULL;
} catch (PDOException $e) {
    msgout($e->getMessage());
}

/* Khang */
// セミナー終了判定
if (date('H') == 20) {
    msgout('----- セミナー終了判定（当日：２０時実行） -----');

    try {
        $db3 = new PDO($ini['dsn'], $ini['user'], $ini['password']);
        $db3->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db3->query('SET CHARACTER SET utf8');

        $db2 = new PDO($ini['dsn'], $ini['user'], $ini['password']);
        $db2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db2->query('SET CHARACTER SET utf8');
        $stt2 = $db2->prepare('SELECT id, place, hiduke, year(hiduke) as y, month(hiduke) as m, day(hiduke) as d, date_format(hiduke,\'%w\') as yobi, date_format(starttime,\'%k:%i\') as sttime, k_title1, t_title1, pax, booking, waitting, new, free, type FROM event_list WHERE starttime <= date_add(now(), interval "0 0" day_hour ) and hiduke = date_sub(current_date(), INTERVAL 0 DAY) ');
        $stt2->execute();
        while ($row2 = $stt2->fetch(PDO::FETCH_ASSOC)) {
            // イベント情報読み込み
            $cur_id = $row2['id'];
            $cur_place = $row2['place'];
            $cur_hiduke = $row2['hiduke'];
            $cur_y = $row2['y'];
            $cur_m = $row2['m'];
            $cur_d = $row2['d'];
            $cur_yobi = $row2['yobi'];
            $cur_sttime = $row2['sttime'];
            $cur_title1 = $row2['t_title1'];
            $cur_pax = $row2['pax'];
            $cur_booking = $row2['booking'];
            $cur_waitting = $row2['waitting'];
            $cur_new = $row2['new'];
            $cur_free = $row2['free'];
            $cur_type = $row2['type'];

            msgout('対象セミナー：' . $cur_id . ' - ' . $cur_title1);

            msgout($cur_id);
            msgout($cur_type);
            msgout($cur_place);

            if ($cur_type != '') {
                // get mail template belong to type (type = mail_id)
                $db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $db->query('SET CHARACTER SET utf8');
                $stt = $db->prepare('SELECT * FROM mailtext WHERE keycd = "mail_temp" AND id = "' . $cur_type . '"');
                $stt->execute();
                while ($row = $stt->fetch(PDO::FETCH_ASSOC)) {
                    $cur_text1 = $row['text1']; // template name
                    $cur_text2 = $row['text2']; // mail title
                    $cur_text3 = $row['text3']; // mail template information
                    $cur_text4 = $row['text4']; // comment
                    $cur_text5 = $row['text5']; // mail_sign, place
                }

                // get mail template signs belong to type (place = text5)
                $db4 = new PDO($ini['dsn'], $ini['user'], $ini['password']);
                $db4->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $db4->query('SET CHARACTER SET utf8');
                $stt4 = $db4->prepare('SELECT * FROM mailtext WHERE keycd = "mail_sign" AND text5 = "' . $cur_place . '"');
                $stt4->execute();

                while ($row4 = $stt4->fetch(PDO::FETCH_ASSOC)) {
                    $cur_sign_id = $row4['id']; // title
                    $cur_sign_text1 = $row4['text1']; // title
                    $cur_sign_text2 = $row4['text2']; // not use
                    $cur_sign_text3 = $row4['text3']; // sign_information
                    $cur_sign_text4 = $row4['text4']; // comment
                    $cur_sign_text5 = $row4['text5']; // mail_sign, place
                }

                if (isset($cur_sign_id)) {
                    // has sign template fit with place, use above
                } else {
                    // load default sign template
                    // get mail sign template belong to type (text5 = default)
                    $db4 = NULL;
                    $db4 = new PDO($ini['dsn'], $ini['user'], $ini['password']);
                    $db4->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $db4->query('SET CHARACTER SET utf8');
                    $stt4 = $db4->prepare('SELECT * FROM mailtext WHERE keycd = "mail_sign" AND text5 = "default"');
                    $stt4->execute();

                    while ($row4 = $stt4->fetch(PDO::FETCH_ASSOC)) {
                        $cur_sign_id = $row4['id']; // title
                        $cur_sign_text1 = $row4['text1']; // title
                        $cur_sign_text2 = $row4['text2']; // not use
                        $cur_sign_text3 = $row4['text3']; // sign_information
                        $cur_sign_text4 = $row4['text4']; // comment
                        $cur_sign_text5 = $row4['text5']; // mail_sign, place
                    }
                }

                // 該当者抽出
                $stt = $db->prepare('SELECT id, seminarid, namae, furigana, tel, email, ninzu, stat, wait, mailstat FROM entrylist WHERE stat = "2" and mailstat <> "5" and mailstat <> "9" and seminarid = "' . $cur_id . '" ORDER BY id');
                $stt->execute();
                $idx = 0;
                while ($row = $stt->fetch(PDO::FETCH_ASSOC)) {
                    // 予約情報読み込み
                    $idx++;
                    $cur_yoyakuid = $row['id'];
                    $cur_seminarid = $row['seminarid'];
                    $cur_namae = $row['namae'];
                    $cur_furigana = $row['furigana'];
                    $cur_tel = $row['tel'];
                    $cur_email = $row['email'];
                    $cur_ninzu = $row['ninzu'];
                    $cur_stat = $row['stat'];
                    $cur_wait = $row['wait'];
                    $cur_mailstat = $row['mailstat'];

                    // ステータス変更
                    $sql = 'UPDATE entrylist SET ';
                    $sql .= '  mailstat = "5"';
                    $sql .= ' ,upddate = "' . date('Y/m/d H:i:s') . '"';
                    $sql .= ' WHERE id = "' . $cur_yoyakuid . '"';
                    $stt3 = $db3->prepare($sql);
                    $stt3->execute();

                    if ($cur_text2 <> '' && $cur_new <> 1 && $cur_free <> 1) {
                        // メール送信
                        $subject = $cur_text2;
                        $data_msg = array(
                            'subscriber_name' => $cur_namae,
                            'seminar_date' => $cur_hiduke,
                            'seminar_title' => $cur_title1,
                            'seminar_id' => $cur_id,
                            'booking_num' => $cur_yoyakuid,
                        );

                        $msg_body = new TemplateFile($cur_text3, $data_msg);
                        //
                        $data_mail = array(
                            'body' => $msg_body,
                            'sign' => $cur_sign_text3
                        );
                        $body = new TemplateFile('tpl/thankyou.tpl', $data_mail);

                        $from = mb_encode_mimeheader(mb_convert_encoding("日本ワーキングホリデー協会", "JIS")) . "<sodan@jawhm.or.jp>";
                        mb_send_mail($cur_email, $subject, $body, "From:" . $from);

                        $cur_email = 'meminfo@jawhm.or.jp';
                        mb_send_mail($cur_email, $subject, $body, "From:" . $from);
                        msgout('　　参加者メール送信　予約番号：' . $cur_yoyakuid . ' - ' . $cur_namae);
                    }
                }
                $db = NULL;
            }
        }
        $db2 = NULL;
        $db3 = NULL;
        $db4 = NULL;
    } catch (PDOException $e) {
        msgout($e->getMessage());
    }
}


if (date('H') == 12) {
    msgout('----- セミナー終了判定（翌日：１２時実行） -----');

    try {
        $db3 = new PDO($ini['dsn'], $ini['user'], $ini['password']);
        $db3->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db3->query('SET CHARACTER SET utf8');

        $db2 = new PDO($ini['dsn'], $ini['user'], $ini['password']);
        $db2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db2->query('SET CHARACTER SET utf8');
        $stt2 = $db2->prepare('SELECT id, place, hiduke, year(hiduke) as y, month(hiduke) as m, day(hiduke) as d, date_format(hiduke,\'%w\') as yobi, date_format(starttime,\'%k:%i\') as sttime, k_title1, pax, booking, waitting, new, free FROM event_list WHERE hiduke = date_sub(current_date(), INTERVAL 1 DAY) ');
        $stt2->execute();
        while ($row2 = $stt2->fetch(PDO::FETCH_ASSOC)) {
            // イベント情報読み込み
            $cur_id = $row2['id'];
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
            $cur_new = $row2['new'];
            $cur_free = $row2['free'];
            $cur_type = $row2['type'];

            msgout('対象セミナー：' . $cur_id . ' - ' . $cur_title1);

            // 欠席者にメール
            $db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $db->query('SET CHARACTER SET utf8');
            $stt = $db->prepare('SELECT * FROM mailtext WHERE keycd = "auto_seminar_kesseki"');
            $stt->execute();
            while ($row = $stt->fetch(PDO::FETCH_ASSOC)) {
                $cur_text1 = $row['text1'];
                $cur_text2 = $row['text2'];
                $cur_text3 = $row['text3'];
                $cur_text4 = $row['text4'];
                $cur_text5 = $row['text5'];
            }

            // 該当者抽出
            $stt = $db->prepare('SELECT id, seminarid, namae, furigana, tel, email, ninzu, stat, wait, mailstat FROM entrylist WHERE stat = "1" and mailstat <> "5" and mailstat <> "9" and seminarid = "' . $cur_id . '" ORDER BY id');
            $stt->execute();
            $idx = 0;
            while ($row = $stt->fetch(PDO::FETCH_ASSOC)) {
                // 予約情報読み込み
                $idx++;
                $cur_yoyakuid = $row['id'];
                $cur_seminarid = $row['seminarid'];
                $cur_namae = $row['namae'];
                $cur_furigana = $row['furigana'];
                $cur_tel = $row['tel'];
                $cur_email = $row['email'];
                $cur_ninzu = $row['ninzu'];
                $cur_stat = $row['stat'];
                $cur_wait = $row['wait'];
                $cur_mailstat = $row['mailstat'];

                // ステータス変更
                $sql = 'UPDATE entrylist SET ';
                $sql .= '  mailstat = "5"';
                $sql .= ' ,stat = "7"';
                $sql .= ' ,upddate = "' . date('Y/m/d H:i:s') . '"';
                $sql .= ' WHERE id = "' . $cur_yoyakuid . '"';
                $stt3 = $db3->prepare($sql);
                $stt3->execute();

                if ($cur_text2 <> '' && $cur_new <> 1 && $cur_free <> 1) {
                    // メール送信
                    $subject = $cur_text2;

                    $data_msg = array(
                        'namae' => $cur_namae,
                        'text3' => $cur_text3,
                        'text4' => $cur_text4,
                        'sign' => $cur_sign_text3,
                    );

                    $body = new TemplateFile('tpl/kesseki.tpl', $data_msg);
                    //

                    $from = mb_encode_mimeheader(mb_convert_encoding("日本ワーキングホリデー協会", "JIS")) . "<sodan@jawhm.or.jp>";
                    mb_send_mail($cur_email, $subject, $body, "From:" . $from);

                    $cur_email = 'meminfo@jawhm.or.jp';
                    mb_send_mail($cur_email, $subject, $body, "From:" . $from);
                    msgout('　　不参加メール送信　予約番号：' . $cur_yoyakuid . ' - ' . $cur_namae);
                }
            }


            if ($cur_type != '') {
                // get mail template belong to type (type = mail_id)
                $db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $db->query('SET CHARACTER SET utf8');
                $stt = $db->prepare('SELECT * FROM mailtext WHERE keycd = "mail_temp" AND id = "' . $cur_type . '"');
                $stt->execute();
                while ($row = $stt->fetch(PDO::FETCH_ASSOC)) {
                    $cur_text1 = $row['text1']; // template name
                    $cur_text2 = $row['text2']; // mail title
                    $cur_text3 = $row['text3']; // mail template information
                    $cur_text4 = $row['text4']; // comment
                    $cur_text5 = $row['text5']; // mail_sign, place
                }

                // get mail template signs belong to type (place = text5)
                $db4 = new PDO($ini['dsn'], $ini['user'], $ini['password']);
                $db4->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $db4->query('SET CHARACTER SET utf8');
                $stt4 = $db4->prepare('SELECT * FROM mailtext WHERE keycd = "mail_sign" AND text5 = "' . $cur_place . '"');
                $stt4->execute();

                while ($row4 = $stt4->fetch(PDO::FETCH_ASSOC)) {
                    $cur_sign_id = $row4['id']; // title
                    $cur_sign_text1 = $row4['text1']; // title
                    $cur_sign_text2 = $row4['text2']; // not use
                    $cur_sign_text3 = $row4['text3']; // sign_information
                    $cur_sign_text4 = $row4['text4']; // comment
                    $cur_sign_text5 = $row4['text5']; // mail_sign, place
                }

                if (isset($cur_sign_id)) {
                    // has sign template fit with place, use above
                } else {
                    // load default sign template
                    // get mail sign template belong to type (text5 = default)
                    $db4 = NULL;
                    $db4 = new PDO($ini['dsn'], $ini['user'], $ini['password']);
                    $db4->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $db4->query('SET CHARACTER SET utf8');
                    $stt4 = $db4->prepare('SELECT * FROM mailtext WHERE keycd = "mail_sign" AND text5 = "default"');
                    $stt4->execute();

                    while ($row4 = $stt4->fetch(PDO::FETCH_ASSOC)) {
                        $cur_sign_id = $row4['id']; // title
                        $cur_sign_text1 = $row4['text1']; // title
                        $cur_sign_text2 = $row4['text2']; // not use
                        $cur_sign_text3 = $row4['text3']; // sign_information
                        $cur_sign_text4 = $row4['text4']; // comment
                        $cur_sign_text5 = $row4['text5']; // mail_sign, place
                    }
                }

                // 該当者抽出
                $stt = $db->prepare('SELECT id, seminarid, namae, furigana, tel, email, ninzu, stat, wait, mailstat FROM entrylist WHERE stat = "2" and mailstat <> "5" and mailstat <> "9" and seminarid = "' . $cur_id . '" ORDER BY id');
                $stt->execute();
                $idx = 0;
                while ($row = $stt->fetch(PDO::FETCH_ASSOC)) {
                    // 予約情報読み込み
                    $idx++;
                    $cur_yoyakuid = $row['id'];
                    $cur_seminarid = $row['seminarid'];
                    $cur_namae = $row['namae'];
                    $cur_furigana = $row['furigana'];
                    $cur_tel = $row['tel'];
                    $cur_email = $row['email'];
                    $cur_ninzu = $row['ninzu'];
                    $cur_stat = $row['stat'];
                    $cur_wait = $row['wait'];
                    $cur_mailstat = $row['mailstat'];

                    // ステータス変更
                    $sql = 'UPDATE entrylist SET ';
                    $sql .= '  mailstat = "5"';
                    $sql .= ' ,upddate = "' . date('Y/m/d H:i:s') . '"';
                    $sql .= ' WHERE id = "' . $cur_yoyakuid . '"';
                    $stt3 = $db3->prepare($sql);
                    $stt3->execute();

                    if ($cur_text2 <> '' && $cur_new <> 1 && $cur_free <> 1) {
                        // メール送信
                        $subject = $cur_text2;

                        $data_msg = array(
                            'namae' => $cur_namae,
                            'text3' => $cur_text3,
                            'text4' => $cur_text4,
                            'sign' => $cur_sign_text3,
                        );

                        $body = new TemplateFile('tpl/kesseki.tpl', $data_msg);
                        //

                        $from = mb_encode_mimeheader(mb_convert_encoding("日本ワーキングホリデー協会", "JIS")) . "<sodan@jawhm.or.jp>";
                        mb_send_mail($cur_email, $subject, $body, "From:" . $from);

                        $cur_email = 'meminfo@jawhm.or.jp';
                        mb_send_mail($cur_email, $subject, $body, "From:" . $from);
                        msgout('　　参加者メール送信　予約番号：' . $cur_yoyakuid . ' - ' . $cur_namae);
                    }
                }
                $db = NULL;
            }
        }
        $db2 = NULL;
        $db3 = NULL;
        $db4 = NULL;
    } catch (PDOException $e) {
        msgout($e->getMessage());
    }
}




msgout('終了');

function msgout($msg) {
    echo date('Y/m/d H:i:s') . ' ' . $msg . '<br/>';
}

function sendmail($subject, $body1, $body2, $cur_namae, $cur_place, $cur_y, $cur_m, $cur_d, $cur_yobi, $cur_sttime, $cur_title1, $cur_yoyakuid, $cur_email, $cur_desc1) {

    if ($cur_email == '') {
        return true;
    }

    // メール送信
    $youbi = Array("日", "月", "火", "水", "木", "金", "土");

    $cur_title1 = strip_tags($cur_title1);
    $cur_title1 = preg_replace("/<img[^>]+\>/i", "", $cur_title1);
    $cur_title1 = mb_convert_kana($cur_title1, "K");

    $cur_desc1 = strip_tags($cur_desc1);
    $cur_desc1 = preg_replace("/<img[^>]+\>/i", "", $cur_desc1);
    $cur_desc1 = mb_convert_kana($cur_desc1, "K");

    $body = '';
    $body .= '' . $cur_namae . '様' . chr(10);
    $body .= chr(10);
    $body .= '日本ワーキングホリデー協会です。' . chr(10);
    $body .= chr(10);
    if ($body1 <> '') {
        $body .= $body1 . chr(10);
        $body .= chr(10);
    }


    $body .= '─────────────────────────' . chr(10);
    $body .= '　「' . $cur_title1 . '」' . chr(10);
    $body .= '─────────────────────────' . chr(10);
    $body .= chr(10);
    $body .= '≪日時≫' . chr(10);
    $body .= '　' . $cur_y . '年 ' . $cur_m . '月 ' . $cur_d . '日 (' . $youbi[$cur_yobi] . '曜日)   ' . $cur_sttime . ' 開始' . chr(10);
    $body .= chr(10);
    $body .= '≪会場≫' . chr(10);
    switch ($cur_place) {
        case 'tokyo':
            $body .='　東京会場' . chr(10);
            $body .='　http://www.jawhm.or.jp/event/map?p=tokyo&wh=s03' . chr(10);
            $body .='　=== 新宿駅からの道順はこちら ===' . chr(10);
            $body .='　http://www.jawhm.or.jp/blog/tokyoblog/item/496' . chr(10);
            break;
        case 'osaka':
            $body .='　大阪会場' . chr(10);
            $body .='　http://www.jawhm.or.jp/event/map?p=osaka&wh=s03' . chr(10);
            break;
        case 'nagoya':
            $body .='　名古屋会場' . chr(10);
            $body .='　http://www.jawhm.or.jp/event/map?p=nagoya&wh=s03' . chr(10);
            break;
        case 'fukuoka':
            $body .='　福岡会場' . chr(10);
            $body .='　http://www.jawhm.or.jp/event/map?p=fukuoka&wh=s03' . chr(10);
            break;
        case 'sendai':
            $body .='　仙台会場' . chr(10);
            break;
        case 'toyama':
            $body .='　富山会場' . chr(10);
            break;
        case 'okinawa':
            $body .='　沖縄会場' . chr(10);
            $body .='　http://www.jawhm.or.jp/event/map?p=okinawa&wh=s03' . chr(10);
            break;
    }

    $body .= chr(10);
    $body .= '' . $cur_desc1 . '' . chr(10);
    $body .= chr(10);

    if ($body2 <> '') {
        $body .= $body2 . chr(10);
        $body .= chr(10);
    }
    $body .= '';
    $body .= '≪予約状態の確認≫' . chr(10);
    $body .= '予約状態の確認・キャンセルなどは以下のURLからどうぞ' . chr(10);
    $body .= 'http://www.jawhm.or.jp/yoyaku/disp/' . $cur_yoyakuid . '/' . md5($cur_email) . chr(10);

    $body .= chr(10);
    $body .= chr(10);

    $body .= '┏┓━━━━━━━━━━━━━━' . chr(10);
    $body .= '┗■　メンバー登録のご案内' . chr(10);
    $body .= '━━━━━━━━━━━━━━━━' . chr(10);
    $body .= 'メンバー登録はワーホリ成功の第一歩！' . chr(10);
    $body .= '' . chr(10);
    $body .= 'ワーキングホリデーや留学には興味があるけれど、' . chr(10);
    $body .= '　● 海外で何ができるのか？' . chr(10);
    $body .= '　● 何をしなければいけないのか？' . chr(10);
    $body .= '　● どんな準備や手続きが必要なのか？' . chr(10);
    $body .= '　● どのくらい費用がかかるのか？' . chr(10);
    $body .= '　● 渡航先で困ったときはどうすればよいのか？' . chr(10);
    $body .= '' . chr(10);
    $body .= '解らない事が多すぎて、もっと解らなくなってしまいます。' . chr(10);
    $body .= '' . chr(10);
    $body .= 'そんな皆様を支援するために当協会では、' . chr(10);
    $body .= 'ワーホリ成功のためのメンバーサポート制度をご用意しています。' . chr(10);
    $body .= '当協会のメンバーになれば、個別相談をはじめビザ取得のお手伝い、' . chr(10);
    $body .= '出発前の準備、到着後のサポートまで、フルにサポートさせて頂きます。' . chr(10);
    $body .= '' . chr(10);
    $body .= '▼▼▼▼▼ メンバー登録はこちらから ▼▼▼▼▼' . chr(10);
    $body .= '　http://www.jawhm.or.jp/mem?wh=s03' . chr(10);
    $body .= '' . chr(10);
    $body .= '' . chr(10);

    $body .= '……‥‥‥‥‥・・‥‥‥‥‥……' . chr(10);
    $body .= '　日本ワーキングホリデー協会' . chr(10);
    $body .= '　http://www.jawhm.or.jp' . chr(10);
    $body .= '　E-mail : info@jawhm.or.jp' . chr(10);
    $body .= '……‥‥‥‥‥・・‥‥‥‥‥……' . chr(10);
    $body .= '' . chr(10);
    $body .= '';

    $from = mb_encode_mimeheader(mb_convert_encoding("日本ワーキングホリデー協会", "JIS")) . "<info@jawhm.or.jp>";
    mb_send_mail($cur_email, $subject, $body, "From:" . $from);
}

?>
