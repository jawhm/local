<?php

mb_language("Ja");
mb_internal_encoding("utf8");

require_once('./include/mem_function.php');
require_once('./include/set_param.php');

//mb_language("Ja");
//mb_internal_encoding("utf8");
// Check step1 Data

$list_fields = array('email', 'password', 'password2', 'name', 'firstname', 'phonetic_name', 'phonetic_firstname', 'gender', 'select-choice-year', 'select-choice-month', 'select-choice-day', 'postcode', 'province', 'municipality', 'address', 'phonenumber', 'occupation', 'country', 'language-skill', 'travel-purpose', 'know-how', 'guide', 'agree');
$list_mandatory_fields = array('email', 'password', 'password2', 'name', 'firstname', 'phonetic_name', 'phonetic_firstname', 'gender', 'select-choice-year', 'select-choice-month', 'select-choice-day', 'postcode', 'province', 'municipality', 'address', 'phonenumber', 'agree');


//****************************
// Work on step1
//****************************

if ($_POST['step'] == '1') {
    //get all field and checking
    foreach ($list_fields as $field) {
        if (isset($_POST[$field]) && !is_array($_POST[$field])) {
            $$field = secure($_POST[$field]);
        } else if (isset($_POST[$field]) && is_array($_POST[$field])) {
            // taking care of array
            $$field = $_POST[$field];

            foreach ($$field as $key) {
                $newlist = $newlist . $key . ',';
                $$field = secure($newlist);
            }
        } else
            $$field = '';


        if ((in_array($field, $list_mandatory_fields) && empty($$field))) {
            $return = 'error';
        }

        if ($field == 'phonenumber') {
            //format phone number and check it
            $characters_to_remove = array('.', '-', ' ');
            $$field = str_replace($characters_to_remove, '', $$field);
        }

        $list_param = $list_param . '&' . $field . '=' . urlencode(html_entity_decode($$field));
    }

    //passwords are the same???
    if ($password != $password2) {
        $return = 'error';
        $list_param = $list_param . '&same_pswd=no';
    }

    //passwords long enough???
    if (strlen($password) < 5) {
        $return = 'error';

        $list_param = $list_param . '&pswd=short';
    }

    if (!is_numeric($phonenumber) && !empty($phonenumber)) {
        $return = 'error';
        $list_param = $list_param . '&phonecheck=wrong';
    }

    //valid e-mail address
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($email)) {
        $return = 'error';
        $list_param = $list_param . '&mailcheck=wrong';
    } else {
        //Count number of e-mail (already exist ?)
        try {
            //connect to database
            $db = connexion_database();

            $rs = $db->query('SELECT count(*) as number FROM memlist WHERE email ="' . $email . '" ');
            $row = $rs->fetch(PDO::FETCH_ASSOC);
            $countnumber = $row['number'];

            // if alreday exist check column state
            if ($countnumber != 0) {

                $rs_state = $db->query('SELECT id, IF(state = 0, "continue", "end") AS state FROM memlist WHERE email ="' . $email . '" ');
                $result = $rs_state->fetch(PDO::FETCH_ASSOC);
                $state_action = $result['state'];

                //What is the action to undertake?
                if ($state_action == 'end') { //go to step 5
                    $return = 'step5';
                    $list_param = $list_param . '&from=mailexist';
                } elseif ($state_action == 'continue') {
                    // delete old data
                    $stt = $db->prepare('DELETE FROM memlist WHERE id = "' . $result['id'] . '"');
                    $stt->execute();

                    $return = 'step2';
                }
            } else if ($return != 'error') {
                $return = 'step2';
            }

            $db = NULL;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    //redirection
    header("location:member_form.php?return=$return" . $list_param);
    exit;
}

//****************************
// Work on step2
//****************************

if ($_POST['step'] == '2') {
    // Get back the serialized data and put it back as an array  
    $data_array = unserialize(stripslashes($_POST['final_array']));

    //echo $_POST['final_array'];
    //echo debug_array($data_array);		
    // Create the id number
    try {
        //connect to database
        $db = connexion_database();

        $stt = $db->prepare('SELECT max(id) as maxid FROM memlist');
        $stt->execute();
        $idx = 0;
        $cur_id = 'JW000000';
        while ($row = $stt->fetch(PDO::FETCH_ASSOC)) {
            $idx++;
            $cur_id = $row['maxid'];
        }
        $db = NULL;
    } catch (PDOException $e) {
        die($e->getMessage());
    }
    $cur_num = intval(substr($cur_id, -6)) + 1;
    $dat_id = 'JW' . substr('000000' . strval($cur_num), -6);

    // Prepare data
    $dat_email = $data_array['email'];
    $dat_password = md5($data_array['password']);
    $dat_namae = trimspace($data_array['name']) . '  ' . trimspace($data_array['firstname']);
    $dat_furigana = mb_convert_kana(trimspace($data_array['phonetic_name']) . '  ' . trimspace($data_array['phonetic_firstname']), "KC");
    $dat_gender = $data_array['gender'];
    $dat_year = $data_array['select-choice-year'];
    $dat_month = $data_array['select-choice-month'];
    $dat_day = $data_array['select-choice-day'];
    $dat_birth = $dat_year . '/' . $dat_month . '/' . $dat_day;
    $dat_pcode = mb_convert_kana($data_array['postcode'], "a");
    $dat_add1 = $data_array['province'];
    $dat_add2 = $data_array['municipality'];
    $dat_add3 = $data_array['address'];
    $dat_tel = mb_convert_kana($data_array['phonenumber'], "a");

    $dat_job = $data_array['occupation'] = isset($_POST['occupation']) ? $_POST['occupation'] : '';
    $dat_country = $data_array['country'] = isset($_POST['country']) ? $_POST['country'][0] : '';
    $dat_gogaku = $data_array['language-skill'] = isset($_POST['language-skill']) ? $_POST['language-skill'] : '';
    $dat_purpose = $data_array['travel-purpose'] = isset($_POST['travel-purpose']) ? $_POST['travel-purpose'][0] : '';
    $dat_know = $data_array['know-how'] = isset($_POST['know-how']) ? $_POST['know-how'][0] : '';
    $dat_mailsend = $data_array['guide'];
    $dat_agree = $data_array['agree'];

    $dat_kyoten = NULL;

    // 付加情報を設定 random number to check e-mail
    $mail_check = getRandomString(5);

    // Insert data
    try {
        //connect to database
        $db = connexion_database();

        $sql = 'INSERT INTO memlist (';
        $sql .= ' id ,email ,password ,namae ,furigana ,gender ,birth ,pcode ,add1 ,add2 ,add3 ,add4 ,tel ,job ,country ,gogaku ,purpose ,know ,agree ,state ,indate ,mailcheck ,mailcheckdate ,mailsend ,insdate ,upddate, kyoten, sid, payment_url, payment_nb, payment_expired_date';
        $sql .= ') VALUES (';
        $sql .= ' :id ,:email ,:password ,:namae ,:furigana ,:gender ,:birth ,:pcode ,:add1 ,:add2 ,:add3 ,:add4 ,:tel ,:job ,:country ,:gogaku ,:purpose ,:know ,:agree ,:state ,:indate ,:mailcheck ,:mailcheckdate ,:mailsend ,:insdate ,:upddate, :kyoten, :sid, :payment_url, :payment_nb, :payment_expired_date';
        $sql .= ')';
        $stt2 = $db->prepare($sql);
        $stt2->bindValue(':id', $dat_id);
        $stt2->bindValue(':email', $dat_email);
        $stt2->bindValue(':password', $dat_password);
        $stt2->bindValue(':namae', $dat_namae);
        $stt2->bindValue(':furigana', $dat_furigana);
        $stt2->bindValue(':gender', $dat_gender);
        $stt2->bindValue(':birth', $dat_birth);
        $stt2->bindValue(':pcode', $dat_pcode);
        $stt2->bindValue(':add1', $dat_add1);
        $stt2->bindValue(':add2', $dat_add2);
        $stt2->bindValue(':add3', $dat_add3);
        $stt2->bindValue(':add4', NULL);
        $stt2->bindValue(':tel', $dat_tel);
        $stt2->bindValue(':job', $dat_job);
        $stt2->bindValue(':country', $dat_country);
        $stt2->bindValue(':gogaku', $dat_gogaku);
        $stt2->bindValue(':purpose', $dat_purpose);
        $stt2->bindValue(':know', $dat_know);
        $stt2->bindValue(':agree', $dat_agree);
        $stt2->bindValue(':state', '0');
        $stt2->bindValue(':indate', date('Y/m/d'));
        $stt2->bindValue(':mailcheck', $mail_check);
        $stt2->bindValue(':mailcheckdate', NULL);
        $stt2->bindValue(':mailsend', $dat_mailsend);
        $stt2->bindValue(':insdate', date('Y/m/d H:i:s'));
        $stt2->bindValue(':upddate', date('Y/m/d H:i:s'));
        $stt2->bindValue(':kyoten', $dat_kyoten);
        $stt2->bindValue(':sid', NULL);
        $stt2->bindValue(':payment_url', NULL);
        $stt2->bindValue(':payment_nb', NULL);
        $stt2->bindValue(':payment_expired_date', '0000-00-00');
        $stt2->execute();
        $db = NULL;
    } catch (PDOException $e) {
        die($e->getMessage());
    }

    // Send email
    // 社内通知 TO administrator

    $subject = "【メンバー登録：仮登録】  " . $dat_namae . "様  " . $dat_email;
    $body = '';
    $body .= 'メンバー登録の仮登録を受け付けました。';
    $body .= chr(10);
    $body .= chr(10);
    $body .= 'メールアドレス：' . $dat_email;
    $body .= chr(10);
    $body .= 'お名前：' . $dat_namae;
    $body .= chr(10);
    $body .= 'フリガナ：' . $dat_furigana;
    $body .= chr(10);
    $body .= '性別：' . $dat_gender . '  (m:男性 f:女性)';
    $body .= chr(10);
    $body .= '生年月日：' . $dat_birth;
    $body .= chr(10);
    $body .= '郵便番号：' . $dat_pcode;
    $body .= chr(10);
    $body .= '住所１：' . $dat_add1;
    $body .= chr(10);
    $body .= '住所２：' . $dat_add2;
    $body .= chr(10);
    $body .= '住所３：' . $dat_add3;
    $body .= chr(10);
    $body .= '電話番号：' . $dat_tel;
    $body .= chr(10);
    $body .= '職業：' . $dat_job;
    $body .= chr(10);
    $body .= '渡航予定国：' . $dat_country;
    $body .= chr(10);
    $body .= '語学力：' . $dat_gogaku;
    $body .= chr(10);
    $body .= '渡航目的：' . $dat_purpose;
    $body .= chr(10);
    $body .= '協会：' . $dat_know;
    $body .= chr(10);   // 受け取らない 
    $body .= '案内メール：' . $dat_mailsend . '  (0:不要 1:必要)';
    $body .= chr(10);
    $body .= '同意確認：' . $dat_agree;
    $body .= chr(10);
    $body .= chr(10);
    $body .= 'メール承認コード：' . $mail_check;
    $body .= chr(10);
    $body .= '';
    $body .= chr(10);
    $body .= '--------------------------------------';
    $body .= chr(10);
    
    foreach ($data_array as $post_name => $post_value) {
        $body .= chr(10);
        $body .= $post_name . " : " . $post_value;
    }
    $body .= '';
    $from = mb_encode_mimeheader(mb_convert_encoding($dat_namae, "JIS")) . "<" . $dat_email . ">";
    mb_send_mail($mailadmin, $subject, $body, "From:" . $from);

    // 確認メールを送信 To User

    $subject = "メールアドレスの確認です";
    $body = '';
    $body .= '日本ワーキングホリデー協会です。';
    $body .= chr(10);
    $body .= chr(10);
    $body .= 'メールアドレス確認の為の承認コード（５桁）をお送りします。';
    $body .= chr(10);
    $body .= 'この承認コードを、メンバー登録画面で入力してください。';
    $body .= chr(10);
    $body .= chr(10);
    $body .= '承認コード [ ' . $mail_check . ' ]';
    $body .= chr(10);
    $body .= chr(10);
    $body .= 'メンバー登録画面を閉じてしまった場合、以下のＵＲＬをご利用ください。';
    $body .= chr(10);
    $body .= 'https://www.jawhm.or.jp/mem2/confirm.php?u=' . $dat_id . '&m=' . md5($dat_email) . '&c=' . $mail_check;
    $body .= chr(10);
    $body .= chr(10);
    $body .= '◆このメールに覚えが無い場合◆';
    $body .= chr(10);
    $body .= '他の方がメールアドレスを間違えた可能性があります。';
    $body .= chr(10);
    $body .= 'お手数ですが、 info@jawhm.or.jp までご連絡頂ければ幸いです。';
    $body .= chr(10);
    $body .= '';
    $from = mb_encode_mimeheader(mb_convert_encoding("日本ワーキングホリデー協会", "JIS")) . "<info@jawhm.or.jp>";
    mb_send_mail($dat_email, $subject, $body, "From:" . $from);


    //redirection
    header("location:member_form.php?return=step3&email=" . $dat_email);
    exit;
}


//****************************
// Work on step3
//****************************

if ($_POST['step'] == '3') {
    $email = secure($_POST['email']);
    $code = secure($_POST['code']);

    // Retrieve checkmail number in the database
    try {
        //connect to database
        $db = connexion_database();


        $stt = $db->prepare('SELECT id, mailcheck FROM memlist WHERE email = "' . $email . '" ');
        $stt->execute();
        while ($row = $stt->fetch(PDO::FETCH_ASSOC)) {
            $code_mailcheck = $row['mailcheck'];
            $user_id = $row['id'];
        }
        $db = NULL;
    } catch (PDOException $e) {
        die($e->getMessage());
    }

    //　is code correct?
    if ($code == $code_mailcheck && !empty($code)) {
        //update user DATA
        try {
            //connect to database
            $db = connexion_database();

            $stt = $db->prepare('UPDATE memlist SET state=1, mailcheckdate="' . date('Y-n-d') . '", upddate="' . date('Y-n-d H:i:s') . '" WHERE id = "' . $user_id . '"   ');
            $stt->execute();
            $db = NULL;
        } catch (PDOException $e) {
            die($e->getMessage());
        }

        //Get user data
        try {
            //connect to database
            $db = connexion_database();

            $stt = $db->prepare('SELECT id, email, namae, furigana, tel FROM memlist WHERE id = "' . $user_id . '" ');
            $stt->execute();
            while ($row = $stt->fetch(PDO::FETCH_ASSOC)) {
                $dat_email = $row['email'];
                $dat_namae = $row['namae'];
                $dat_furigana = $row['furigana'];
                $dat_tel = $row['tel'];
            }
            $db = NULL;
        } catch (PDOException $e) {
            die($e->getMessage());
        }

        //Send mail to admin
        $subject = "【メンバー登録：メアド承認】  " . $dat_namae . "様  " . $dat_email;
        $body = '';
        $body .= 'メンバー登録でメールアドレスの承認が完了しました。';
        $body .= chr(10);
        $body .= chr(10);
        $body .= 'メールアドレス：' . $dat_email;
        $body .= chr(10);
        $body .= 'お名前：' . $dat_namae;
        $body .= chr(10);
        $body .= 'フリガナ：' . $dat_furigana;
        $body .= chr(10);
        $body .= '電話番号：' . $dat_tel;
        $body .= chr(10);
        $body .= '';
        $from = mb_encode_mimeheader(mb_convert_encoding($dat_namae, "JIS")) . "<" . $dat_email . ">";
        mb_send_mail($mailadmin, $subject, $body, "From:" . $from);

        //redirection
        header("location:member_form.php?return=step4&id=" . $user_id . "&email=" . $dat_email);
        exit;
    } else {
        //redirection
        header("location:member_form.php?return=step3&email=" . $email . "&wrong=1");
        exit;
    }
}


//****************************
// Work on step4
//****************************

if ($_POST['step'] == '4' || isset($_GET['SID'])) {
    //Get data from digitalcheck
    if (isset($_GET['SID'])) {
        //prepare data
        $dat_id = $_GET['FUKA'];
        $target_type = 'card';
    } else
        $target_type = 'none';

    //get sent data by form
    if ($target_type == 'none') {
        $target_type = secure($_POST['target']);
        $dat_id = secure($_POST['userid']);
        $dat_email = secure($_POST['email']); // not really necessary because we need to get the email in the database in case of payment by card
    }

    //Retreive data in database for email body
    try {
        //connect to database
        $db = connexion_database();

        $stt = $db->prepare('SELECT namae, furigana, tel, email FROM memlist WHERE id = "' . $dat_id . '" ');
        $stt->execute();
        while ($row = $stt->fetch(PDO::FETCH_ASSOC)) {
            $dat_namae = $row['namae'];
            $dat_furigana = $row['furigana'];
            $dat_tel = $row['tel'];
            $dat_email = $row['email']; // line needed for the payment by card
        }
        $db = NULL;
    } catch (PDOException $e) {
        die($e->getMessage());
    }


    // Bank transfer
    //---------------

    if ($target_type == 'furikomi') {

        //update databsase for payment
        try {
            //connect to database
            $db = connexion_database();
            $stt = $db->prepare('UPDATE memlist SET payment = "' . $target_type . '" WHERE id = "' . $dat_id . '" ');
            $stt->execute();
            $db = NULL;
        } catch (PDOException $e) {
            die($e->getMessage());
        }


        // Send email
        // 社内通知 
        $subject = "【メンバー登録：振込予約】  " . $dat_namae . "様  " . $dat_email;
        $body = '';
        $body .= 'メンバー登録で振込予約が発生しました。';
        $body .= chr(10);
        $body .= chr(10);
        $body .= '会員番号：' . $dat_id;
        $body .= chr(10);
        $body .= 'メールアドレス：' . $dat_email;
        $body .= chr(10);
        $body .= 'お名前：' . $dat_namae;
        $body .= chr(10);
        $body .= 'フリガナ：' . $dat_furigana;
        $body .= chr(10);
        $body .= '電話番号：' . $dat_tel;
        $body .= chr(10);
        $body .= '';
        $from = mb_encode_mimeheader(mb_convert_encoding($dat_namae, "JIS")) . "<" . $dat_email . ">";

        //To admin
        mb_send_mail($mailadmin, $subject, $body, "From:" . $from);

        //To office
        mb_send_mail($mailoffice, $subject, $body, "From:" . $from);

        // 確認メールを送信 To user
        $subject = "登録料のお振込先をご案内します";
        $body = '';
        $body .= '日本ワーキングホリデー協会です。';
        $body .= chr(10);
        $body .= 'メンバー登録ありがとうございます。';
        $body .= chr(10);
        $body .= chr(10);
        $body .= '登録料のお振込先は以下の通りとなります。';
        $body .= chr(10);
        $body .= '銀行名　：　三井住友銀行 (0009)';
        $body .= chr(10);
        $body .= '支店名　：　新宿支店 (221)';
        $body .= chr(10);
        $body .= '口座番号：　普通　4246817';
        $body .= chr(10);
        $body .= '名義人　：　シャ）ニホンワーキングホリデーキョウカイ';
        $body .= chr(10);
        $body .= chr(10);
        $body .= '登録料　：　５，０００円';
        $body .= chr(10);
        $body .= '会員番号：　' . $dat_id;
        $body .= chr(10);
        $body .= '※振込手数料はご負担ください。';
        $body .= chr(10);
        $body .= '※本日より１週間以内にお振込みください。';
        $body .= chr(10);
        $body .= '※お振込時の振込人名は、お申込みご本人のお名前でお願い致します。';
        $body .= chr(10);
        $body .= '※また可能であれば、振込人名の名前の前に会員番号を付加してください。';
        $body .= chr(10);
        $body .= '　お振込み確認を確実に行うために、皆様のご協力をお願い致します。';
        $body .= chr(10);
        $body .= chr(10);
        $body .= 'お手数ですが、振込後にご連絡を頂けますようお願い申し上げます。';
        $body .= chr(10);
        $body .= '電話番号：03-6304-5858';
        $body .= chr(10);
        $body .= 'メール：info@jawhm.or.jp';
        $body .= chr(10);
        $body .= '';
        $from = mb_encode_mimeheader(mb_convert_encoding("日本ワーキングホリデー協会", "JIS")) . "<info@jawhm.or.jp>";
        mb_send_mail($dat_email, $subject, $body, "From:" . $from);
    }

    // Convenience store
    //------------------

    if ($target_type == 'conv') {

        //Get others sent data
        $dat_payment_nb = secure($_POST['payment_nb']);
        $dat_exp_date = secure($_POST['expired_date']);
        $dat_payment_url = secure($_POST['payment_url']);

        //make date format
        $year = substr($dat_exp_date, 0, 4);
        $month = substr($dat_exp_date, -4, 2);
        $day = substr($dat_exp_date, -2);

        $full_expired_date = $year . '-' . $month . '-' . $day;

        //update user data
        try {
            //connect to database
            $db = connexion_database();

            $stt = $db->prepare('UPDATE memlist SET payment = "' . $target_type . '", payment_expired_date="' . $full_expired_date . '", payment_nb="' . $dat_payment_nb . '", payment_url="' . $dat_payment_url . '" WHERE id = "' . $dat_id . '"   ');
            $stt->execute();
            $db = NULL;
        } catch (PDOException $e) {
            die($e->getMessage());
        }


        // Send email
        //Mail to customer  OK
        $subject = "登録料のお支払についてのご案内です";
        $body = '';
        $body .= '日本ワーキングホリデー協会です。';
        $body .= chr(10);
        $body .= 'メンバー登録ありがとうございます。';
        $body .= chr(10);
        $body .= chr(10);
        $body .= 'お選び頂きましたコンビニにてメンバー登録料のお支払をお願い致します。';
        $body .= chr(10);
        $body .= 'なお、コンビニでのお支払は以下のお支払期限までにお願い致します。';
        $body .= chr(10);
        $body .= chr(10);
        $body .= '受付番号・払込票番号：' . $dat_payment_nb;
        $body .= chr(10);
        $body .= '受付票・払込票表示：' . $dat_payment_url;
        $body .= chr(10);
        $body .= 'お支払期限：' . $full_expired_date;
        $body .= chr(10);
        $body .= chr(10);
        $body .= 'お支払が確認できましたら、ご登録の住所宛てに会員証をお送り致します。';
        $body .= chr(10);
        $body .= chr(10);
        $body .= 'また、コンビニ端末等に事業所名として「株式会社デジタルチェック」と表示される場合がありますが、';
        $body .= chr(10);
        $body .= 'こちらは当協会メンバー登録料の収納代行会社の名前ですので、問題ありません。ご安心下さい。';
        $body .= chr(10);
        $body .= chr(10);
        $body .= 'ご不明点などあれば、以下にご連絡ください。';
        $body .= chr(10);
        $body .= '電話番号：03-6304-5858';
        $body .= chr(10);
        $body .= 'メール：info@jawhm.or.jp';
        $body .= chr(10);
        $body .= '';
        $from = mb_encode_mimeheader(mb_convert_encoding("日本ワーキングホリデー協会", "JIS")) . "<info@jawhm.or.jp>";
//			mb_send_mail($dat_email,$subject,$body,"From:".$from);
        // 社内通知 OK

        $subject = "【メンバー登録：コンビニ決済予約】  " . $dat_namae . "様  " . $dat_email;
        $body = '';
        $body .= 'メンバー登録でコンビニ決済予約が発生しました。';
        $body .= chr(10);
        $body .= chr(10);
        $body .= '会員番号：' . $dat_id;
        $body .= chr(10);
        $body .= 'メールアドレス：' . $dat_email;
        $body .= chr(10);
        $body .= 'お名前：' . $dat_namae;
        $body .= chr(10);
        $body .= 'フリガナ：' . $dat_furigana;
        $body .= chr(10);
        $body .= '電話番号：' . $dat_tel;
        $body .= chr(10);
        $body .= '受付番号・払込票番号：' . $dat_payment_nb;
        $body .= chr(10);
        $body .= '受付票・払込票表示：' . $dat_payment_url;
        $body .= chr(10);
        $body .= '有効期限：' . $full_expired_date;
        $body .= '';
        $from = mb_encode_mimeheader(mb_convert_encoding($dat_namae, "JIS")) . "<" . $dat_email . ">";

        //To admin
//			mb_send_mail($mailadd,$subject,$body,"From:".$from);
        //To office
//			mb_send_mail($mailoffice,$subject,$body,"From:".$from);
    }

    // Credit card
    //------------------

    if ($target_type == 'card') {
        //update user data
        try {
            //connect to database
            $db = connexion_database();

            $stt = $db->prepare('UPDATE memlist SET state="5", payment = "' . $target_type . '" WHERE id = "' . $dat_id . '" ');
            $stt->execute();
            $db = NULL;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    //redirection
    header("location:member_form.php?return=step5&from=" . $target_type);
    exit;
}
?>