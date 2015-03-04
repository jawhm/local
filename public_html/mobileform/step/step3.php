
<?php
$cur_state = '0';

//check if we get from email
if (isset($_GET['m'])) {
    $m = secure($_GET['m']);
    $u = secure($_GET['u']);

    // get mail from database
    try {
        //connect to database
        $db = connexion_database();

        $stt = $db->prepare('SELECT email,state FROM memlist WHERE id="' . $u . '"');
        $stt->execute();
        while ($row = $stt->fetch(PDO::FETCH_ASSOC)) {
            $cur_email = $row['email'];
            $cur_state = $row['state'];
        }
        $db = NULL;
    } catch (PDOException $e) {
        die($e->getMessage());
    }

    //compare two mails
    if ($m != md5($cur_email)) {
        //redirect to the beginning of the registration form
        header("location:member_form.php");
    } else {
        $final_array['email'] = $cur_email;
    }
}
?>

<div data-role="page" id="step3" class="jquery">

    <div id="header-box">
        <h1>メンバー登録</h1>
    </div><!-- /header -->

    <div data-role="content" data-theme="b">
        <h2>STEP 3</h2>
        <?php
        if ($cur_state == '0') {
            ?>
            <h3>メールをご確認の上、承認コードを入力してください </h3>
            <p>ご入力頂いたメールアドレス (<?php echo $final_array['email']; ?>) に、承認コードをお送りしました。<br />
                メールをご覧になり、以下の内容を入力してください。<br /><br />
                なお、承認コードは「５桁の半角英数字」のコードです。 			
            </p>
            <?php
            if ($_GET['wrong'] == 1) {
                ?>
                <div class="titlebar">
                    <p>入力された承認コードが一致しません。<br />
                        お送りしたメールを、もう一度確認してください。<br />
                        また、承認コードはコピー＆ペーストせず、必ず入力してください。</p>
                </div>
                <?php
            }
            ?>

            <div data-role="fieldcontain" >
                <form name="step3form" method="post" action="check.php" data-ajax="false">
                    <input type="hidden" name="step" value="3" />
                    <input type="hidden" name="email" value="<?php echo $final_array['email']; ?>" />
                    <fieldset data-role="controlgroup" data-type="horizontal"> 
                        <label for="code" >承認コード</label>
                        <input type="text" name="code" id="code" data-mini="true" value="<?php echo @$_GET['c']; ?>" />
                    </fieldset>
                    <a href="" type="button" data-theme="b" data-icon="back" data-rel="back" data-inline="true" />戻る</a>
                    <input type="submit" value="次へ" data-theme="b" data-icon="check" data-inline="true" />
                </form>
            </div>

            <?php
        } else {
            ?>
            <h3>このメールアドレスは、既に承認されています。 </h3>
            <?php
        }
        ?>


    </div><!-- /content -->

    <?php echo footer(); ?>

</div>