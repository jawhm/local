    
<div data-role="page" id="form" class="jquery">
    <div id="header-box">
        <h1>メンバー登録</h1>
    </div><!-- /header -->

    <div data-role="content">	
        <h2>STEP 1</h2>
        <h3>お客様情報をご入力下さい</h3>
        <form id="step1" name="step1" action="check.php" method="post" data-ajax="false">

            <div data-role="fieldcontain" class="div-form">
                <span class="mandatory<?php echo $field_type['email'] ?>">メールアドレス <span class="text-type">[半角英数字]</span></span>
                <input class="<?php echo $field_type['email'] ?>" type="email" name="email" id="email" data-mini="true" value="<?php echo $field_value['email']; ?>" placeholder="例） mail@jawhm.or.jp" />
                <?php
                if ($field_type['email'] == '_field_error') {
                    if ($wrong_email_format)
                        echo '<p class="msg_error">正しいメールアドレスを入力してください。</p>';
                    else
                        echo '<p class="msg_error">メールアドレスを入力してください</p>';
                }
                ?>
                <div data-role="collapsible" data-mini="true" data-iconpos="notext" data-theme="f">
                    <h3 class="moreinfo"></h3>
                    <p class="moretext">
                        ※ログイン用のメールアドレスとなります<br />	
                        ※携帯電話でのメールアドレスをご使用の場合<br />
                        jawhm.or.jpドメインからのメールを受信できるように設定を確認してください<br />
                        ※次のようなメールアドレスはご利用いただけません。<br />	
                        １．メールアドレスの @ の直前にピリオド (.) がある<br />
                        ２． @ より前でピリオドが連続する<br />
                        恐れ入りますが、他のメールアドレスでご登録ください
                    </p>
                </div>

                ※ご確認の メールを お送りしますので、連絡可能な メールアドレスを 入力してください。 
            </div>
            <div data-role="fieldcontain" class="div-form">
                <span class="mandatory<?php echo $field_type['password'] ?><?php echo $field_type['password2'] ?>">パスワード <span class="text-type">[半角英数字]</span></span>
                <p>※登録後、メンバー専用ページへのログインの際に必要となります。</p>
                <input class="<?php echo $field_type['password'] ?>" type="password" maxlength="20" name="password" id="password" data-mini="true" value="<?php echo $field_value['password']; ?>"  />
                <?php
                if ($field_type['password'] == '_field_error') {
                    if ($different_password == 2)
                        echo '<p class="msg_error">パスワードは５文字以上で設定してください。</p>';
                    else
                        echo '<p class="msg_error">パスワードを入力してください。</p>';
                }
                ?>
                <div data-role="collapsible" data-mini="true" data-iconpos="notext" data-theme="f" >
                    <h3 class="moreinfo"></h3>
                    <p class="moretext">※メンバー専用ページにログインする際のパスワードとなります。</p>
                </div>
                ※半角英数字５～２０文字で入力してください。 <br /><br />
                <input class="<?php echo $field_type['password2'] ?>" type="password" maxlength="20" name="password2" id="password2" data-mini="true" value="<?php echo $field_value['password2']; ?>"  />
                <?php
                if ($field_type['password2'] == '_field_error') {
                    if ($different_password == 1)
                        echo '<p class="msg_error">上記のパスワードと異なります。確認してください。</p>';
                    else
                        echo '<p class="msg_error">パスワードを再度入力してください。</p>';
                } else
                    echo '<br />';
                ?>
                ※確認の為、同じパスワードを入力してください。 
            </div>

            <div data-role="fieldcontain" class="div-form">
                <span class="mandatory<?php echo $field_type['name'] ?><?php echo $field_type['firstname'] ?>">お名前 <span class="text-type">[全角]</span></span>
                <div class="part1">
                    <input class="<?php echo $field_type['name'] ?>" type="text" name="name" id="name" data-mini="true" placeholder="姓 . 例） 山田" value="<?php echo html_entity_decode($field_value['name']); ?>" />
                    <?php
                    if ($field_type['name'] == '_field_error')
                        echo '<p class="msg_error">お名前（氏）を入力してください</p>';
                    ?>
                </div>
                <div class="part2">
                    <input class="<?php echo $field_type['firstname'] ?>" type="text" name="firstname" id="firstname" data-mini="true" value="<?php echo html_entity_decode($field_value['firstname']); ?>" placeholder="名 . 例） 太郎" />
                    <?php
                    if ($field_type['firstname'] == '_field_error')
                        echo '<p class="msg_error">お名前（名）を入力してください</p>';
                    ?>
                </div>

            </div>


            <div data-role="fieldcontain" class="div-form">
                <span class="mandatory<?php echo $field_type['phonetic_name'] ?><?php echo $field_type['phonetic_firstname'] ?>">ふりがな <span class="text-type">[ひらがな]</span></span>
                <div class="part1">
                    <input class="<?php echo $field_type['phonetic_name'] ?>" type="text" name="phonetic_name" id="phonetic_name" data-mini="true" value="<?php echo html_entity_decode($field_value['phonetic_name']); ?>" placeholder="せい . 例） やまだ" data-inline="true" />
                    <?php
                    if ($field_type['phonetic_name'] == '_field_error')
                        echo '<p class="msg_error">フリガナ（氏）を入力してください</p>';
                    ?>
                </div>
                <div class="part2">
                    <input class="<?php echo $field_type['phonetic_firstname'] ?>" type="text" name="phonetic_firstname" id="phonetic_firstname" data-mini="true" value="<?php echo html_entity_decode($field_value['phonetic_firstname']); ?>" placeholder="めい .例） たろう"  />
                    <?php
                    if ($field_type['phonetic_firstname'] == '_field_error')
                        echo '<p class="msg_error">フリガナ（名）を入力してください</p>';
                    ?>
                </div>    
            </div>


            <div data-role="fieldcontain" class="div-form">
                <span class="mandatory">性別</span>

                <fieldset data-role="controlgroup" data-type="horizontal">
                    <input type="radio" name="gender" id="gender-man" value="m"  data-mini="true" <?php if ($field_value['gender'] == 'm' || !isset($field_value['gender'])) echo'checked'; ?> />
                    <label for="gender-man">男性</label>
                    <input type="radio" name="gender" id="gender-woman" value="f"  data-mini="true" <?php if ($field_value['gender'] == 'f') echo'checked'; ?> />
                    <label for="gender-woman">女性</label>
                </fieldset>
            </div>

            <div data-role="fieldcontain" class="div-form">

                <span class="mandatory">生年月日</span>

                <fieldset data-role="controlgroup" data-type="horizontal">
                    <label for="select-choice-year">年</label>
                    <select name="select-choice-year" id="select-choice-year"  data-mini="true">
                        <?php
                        for ($i = 1970; $i <= date('Y'); $i++) {
                            echo '<option value="' . $i . '"';
                            if ($field_value['select-choice-year'] == $i)
                                echo'selected';
                            elseif ($i == (date('Y') - 22))
                                echo'selected';
                            echo '>' . $i . '年</option>';
                        }
                        ?>                            
                    </select>

                    <label for="select-choice-month">月</label>
                    <select name="select-choice-month" id="select-choice-month"  data-mini="true">
                        <?php
                        for ($i = 1; $i <= 12; $i++) {
                            echo '<option value="' . $i . '"';
                            if ($field_value['select-choice-month'] == $i)
                                echo'selected';
                            echo '>' . $i . '月</option>';
                        }
                        ?>                            
                    </select>

                    <label for="select-choice-day">日</label>
                    <select name="select-choice-day" id="select-choice-day"  data-mini="true">
                        <?php
                        for ($i = 1; $i <= 31; $i++) {
                            echo '<option value="' . $i . '"';
                            if ($field_value['select-choice-day'] == $i)
                                echo'selected';
                            echo '>' . $i . '日</option>';
                        }
                        ?>                            
                    </select>

                </fieldset> 
            </div>

            <div data-role="fieldcontain" class="div-form">
                <span class="mandatory<?php echo $field_type['postcode'] ?>">郵便番号 <span class="text-type">[半角数字]</span></span>
                <input class="<?php echo $field_type['postcode'] ?>" type="text" name="postcode" pattern="[0-9]*" id="postcode" data-mini="true" value="<?php echo $field_value['postcode']; ?>" onKeyUp="AjaxZip2.zip2addr(this, 'province', 'municipality', null, 'municipality');" placeholder="例） 160-0023" />
                <?php
                if ($field_type['postcode'] == '_field_error')
                    echo '<p class="msg_error">郵便番号を入力してください</p>';
                ?>
                <p>郵便番号をご入力頂くと、ご住所が自動で入力されます。<!--<a href="http://www.post.japanpost.jp/zipcode/" target="_blank" data-role="button" data-icon="info" data-mini="true">[ 〒郵便番号検索ページへ ]</a>--></p>
            </div>

            <div data-role="fieldcontain" class="div-form">
                <span class="mandatory<?php echo $field_type['province'] ?>">都道府県 <span class="text-type">[全角]</span></span>
                <input class="<?php echo $field_type['province'] ?>" type="text" name="province" id="province" data-mini="true" value="<?php echo html_entity_decode($field_value['province']); ?>" placeholder="例） 東京都" />
                <?php
                if ($field_type['province'] == '_field_error')
                    echo '<p class="msg_error">都道府県を入力してください</p>';
                ?>
            </div>

            <div data-role="fieldcontain" class="div-form">
                <span class="mandatory<?php echo $field_type['municipality'] ?>">市区町村 <span class="text-type">[全角]</span></span>
                <input class="<?php echo $field_type['municipality'] ?>" type="text" name="municipality" id="municipality" data-mini="true" value="<?php echo html_entity_decode($field_value['municipality']); ?>" placeholder="例） 新宿区西新宿" />
                <?php
                if ($field_type['municipality'] == '_field_error')
                    echo '<p class="msg_error">市区町村を入力してください</p>';
                ?>
            </div>

            <div data-role="fieldcontain" class="div-form">
                <span class="mandatory<?php echo $field_type['address'] ?>">番地・建物名 <span class="text-type">[全角]</span></span>
                <textarea class="<?php echo $field_type['address'] ?>" cols="40" rows="8" name="address" id="address" placeholder="例） １－３－３　ステーションビル５０７"><?php echo html_entity_decode($field_value['address']); ?></textarea>
                <?php
                if ($field_type['address'] == '_field_error')
                    echo '<p class="msg_error">番地・建物名を入力してください</p>';
                ?>
                <div data-role="collapsible" data-mini="true" data-iconpos="notext" data-theme="f" >
                    <h3 class="moreinfo"></h3>
                    <p class="moretext">※海外からの場合、国名を「都道府県」の欄に入力し<br/>
						　残りの住所を「市区町村」「番地・建物名」に入力してください</p>
                </div>
                ※メンバーズカードをお送りします。<br/>
                宛先不明でカードがお送り出来ない事が多くあります。必ず<b>アパート・マンション名など</b>も入力してください。<br/>                    
            </div>

            <div data-role="fieldcontain" class="div-form">
                <span class="mandatory<?php echo $field_type['phonenumber'] ?>">電話番号 <span class="text-type">[半角数字]</span></span>
                <input class="<?php echo $field_type['phonenumber'] ?>" type="text" pattern="[0-9]*" name="phonenumber" id="phonenumber" data-mini="true" value="<?php echo $field_value['phonenumber']; ?>" placeholder="例） 0363045858" />
                <?php
                if ($field_type['phonenumber'] == '_field_error') {
                    if ($wrong_phone_format)
                        echo '<p class="msg_error">ハイフンの入力は不要です（電話番号は半角数字で入力してください）</p>';
                    else
                        echo '<p class="msg_error">電話番号を入力してください </p>';
                } else
                    echo'<br />※ハイフンは入力不要です。';
                ?>
            </div>

            <div data-role="fieldcontain" class="div-form">
                <?php if ($field_type['agree']) { ?>
                    <span class="mandatory_field_error">利用規約同意</span>
                <?php } else { ?>
                    <span class="mandatory<?php echo $field_type['agree'] ?>">利用規約同意</span>
                <?php } ?>
                <span class="title">必ず以下の、「メンバー規約」「プライバシーポリシー」「ビザ申請に関する重要事項」を読みご理解の上、メンバー登録を行ってください。</span>
                <a href="#members-term" data-role="button" data-rel="dialog" data-icon="info" data-transition="pop" data-mini="true" data-inline="true">【　メンバー規約　】</a>
                <a href="#privacy-policy" data-role="button" data-rel="dialog" data-icon="info" data-transition="pop" data-mini="true" data-inline="true" >【　プライバシーポリシー　】</a>
                <a href="#visa-suport" data-role="button" data-rel="dialog" data-icon="info" data-transition="pop" data-mini="true" data-inline="true" >【　ビザ申請に関する重要事項　】</a>

                <input type="checkbox" id="agree" name="agree" value="1" data-mini="true" <?php if ($field_value['agree'] == 1) echo 'checked'; ?> />
                <label for="agree">「メンバー規約」に同意します。</label>
                <?php
                if ($field_type['agree'] == '_field_error')
                    echo '<p class="msg_error">メンバー登録には、メンバー規約への同意が必要です。</p>';
                ?>

            </div>

            <input type="hidden" value="1" name="step" />
            <input type="submit" value="次へ" data-theme="b" data-icon="forward" />
        </form>

    </div><!-- /content -->

    <?php echo footer(); ?>

</div><!-- /page -->

<!-- Start of second page: #members-term -->
<div data-role="page" id="members-term">

    <div data-role="header" data-theme="b">
        <h1>メンバー登録</h1>
    </div><!-- /header -->

    <div data-role="content" data-theme="b" class="info">	
        <p>第１条（メンバー登録）<br/>
            当協会の活動内容・趣旨を理解し、ワーキング・ホリデー制度に興味を持ち、海外体験によって自分自身のキャリアアップを図ろうと考えている者、ワーキング・ホリデー制度を利用して渡航を準備している者、及び帰国後就職を希望している者等をメンバー登録の対象とする。<br/>
            ワーキング・ホリデーで来日している外国人については、別途定める。<br/>
            &nbsp;<br/>
            第２条（メンバー情報の届出）<br/>
            メンバー登録時に必要な氏名・連絡先等の事項を当協会に届出る必要がある。また、これら当協会に届け出た事項に変更があった場合は、当協会に延滞なく届け出るもとのする。<br/>
            &nbsp;<br/>
            第３条（有効期間）<br/>
            メンバー資格の有効期間は、資格を得てから3年間とする。引き続きワーキング・ホリデーを利用する際のメンバー更新の有効期間は更新後2年間とする。<br/>
            &nbsp;<br/>
            第４条（登録料）<br/>
            メンバー登録料は5,000円とする。更新料は2,000円。<br/>
            &nbsp;<br/>
            第５条（メンバー登録の取り消しと登録料の返金）<br/>
            当協会のセミナー、個別相談（カウンセリング）等のサービス提供前の場合は、メンバー登録の取り消しを可能としメンバー登録料を全額返金する。<br/>
            但し、登録日より６０日経過した場合、納入した登録料は、理由の如何を問わず返金しない。<br/>
            また、メンバー都合によるメンバー登録取り消しに際し、登録料の返金手数料（銀行振込手数料など）が発生する場合はメンバーの負担とする。<br/>
            &nbsp;<br/>
            第６条（メンバーズカード）<br/>
            登録した者にメンバーズカードを発行する。これをもって「一般社団法人 日本ワーキング・ホリデー協会メンバー」とする。メンバーズカードは本人のみ有効で、ワーキング・ホリデー中は常時携帯する。第三者に譲渡又は貸与することは出来ず、かつこの場合効力は失われる。メンバーズカードを紛失、盗難にあった場合には、直ちに協会に連絡する。<br/>
            &nbsp;<br/>
            第７条（再発行）<br/>
            メンバーズカードを失った場合、再発行することができるが、再発行料は、1,000円とする。<br/>
            &nbsp;<br/>
            第８条（禁止事項）<br/>
            メンバーは、当協会及び提携団体（機関、会社等を含む）のサービスを利用して以下の行為を行わないものとする。<br/>
            １．当協会又は当協会の正会員・賛助会員及び広告先、又は第三者の著作権、商標権等の知的財産権を侵害する行為、または侵害するおそれのある行為。<br/>
            ２．他のサービス利用者又は第三者の財産、プライバシーもしくは肖像権を侵害する行為、または侵害するおそれのある行為。<br/>
            ３．他のサービス利用者又は第三者を差別もしくは誹謗中傷し、または他者の名誉もしくは信用を毀損する行為。<br/>
            ４．他のサービス利用者又は当協会及び提携団体（機関、会社等を含む）のスタッフもしくは第三者に対する勧誘行為もしくは販売行為。<br/>
            ５．公序良俗に違反する行為。<br/>
            ６．当協会及び提携団体（機関、会社等を含む）のサービスの運営を妨害する行為。<br/>
            ７．上記各号の他、法令、またはこのメンバー規約に違反する行為。その他当協会が不適切と判断する行為。<br/>
            &nbsp;<br/>
            第９条（メンバー登録の解除）<br/>
            以下の場合、当協会は催促その他何らの手続きを要せずメンバー登録を解除することができる。
            この場合、当協会及び提携団体（機関、会社等を含む）からのサービス提供の有無に係らず、メンバー登録料の返金は一切行わない。<br />
            １．メンバー登録の内容に虚偽がある場合<br />
            ２．メンバーの都合により当協会及び提携団体からのサービス提供が困難な場合<br />
            ３．メンバー登録の趣旨に当てはまらない登録<br />
            ４．前項の禁止事項に該当する場合<br />
            ５．上記各号の他、当協会が不適当と判断する場合<br />
            &nbsp;<br/>
            第１０条（規約の変更等）<br/>
            本規約の内容は、予告なく、改正または廃止することがある。<br/>
            &nbsp;<br/>
            以上<br/></p>		
    </div><!-- /content -->

</div><!-- /page members-term -->

<!-- Start of third page: #privacy-policy -->
<div data-role="page" id="privacy-policy">

    <div data-role="header" data-theme="b">
        <h1>メンバー登録</h1>
    </div><!-- /header -->

    <div data-role="content" data-theme="b" class="info">	
        <p>一般社団法人日本ワーキング・ホリデー協会（以下、当協会という）では、ワーキングホリデー制度の運営及び各種手続きを行うにあたり、様々な個人情報をお預かりしております。<br/>
            当協会は、そのお預かりしている個人情報を、最も大切な資産の一つとし、その保護・管理を協会活動の最重要事項として大切に取り扱うこととしています。具体的には、下記の通り個人情報保護に関する方針を定め、職員全員に周知徹底し、皆さまの個人情報の適切な取扱い・管理をお約束します。<br/>
            &nbsp;<br/>
            １．個人情報の定義<br/>
            個人情報とは個人に関する情報であり、住所、氏名、生年月日、メールアドレスまたはサイトへのアクセス記録により、その個人を識別できるものをさします。当該情報だけではなく、他の情報との照合によって判別できる情報も含まれます。<br/>
            &nbsp;<br/>
            ２．個人情報の利用目的<br/>
            当協会では事業遂行上、必要な個人情報を適正かつ公正な手段で取得しますが、これらの個人情報は明確に使用目的を限定し、厳正に管理します。また、業務を円滑に進めるため業務の一部を委託し、この業務委託先に対して必要な個人情報を提供することがありますが、当協会はこれら業務委託先との間で取扱いに関する契約締結をはじめ、適切な監督を行います。当協会が取得する個人情報は以下の目的で利用します。<br/>
            &nbsp;<br/>
            （利用目的）<br/>
            　　・　セミナー・語学講座等のイベント案内、商品・サービスの情報や宣伝物等の提供<br/>
            　　・　当協会提供のサービスやシステムの保守・サポート<br/>
            　　・　各種事業に関するマーケティングや調査、お客様からのお問合せへの回答<br/>
            　　・　職業紹介事業における求職者、求人企業への情報提供と付随する業務<br/>
            　　・　その他、お客様との取引・契約を適切かつ円滑に履行するため<br/>
            &nbsp;<br/>
            ３．個人情報の利用に関する免責事項<br/>
            当協会では、以下の場合を除き、本人の同意なく第三者に個人データを提供しません。<br/>
            &nbsp;<br/>
            　　・　法令に基づく場合<br/>
            　　・　人の生命、身体又は財産を保護するにあたり、本人の同意を得ることが困難であるとき<br/>
            　　・　当協会からお客様へ情報提供を行う際、郵送物の配達業務または情報の配信を委託する場合で、必要と思われる組織・団体に対して個人情報の提供を行うとき<br/>
            &nbsp;<br/>
            ４．個人情報の安全管理措置<br/>
            当協会は、取扱う個人データの漏洩、滅失または毀損の防止その他の個人データの安全管理のため、十分なセキュリティ対策を講じるとともに、利用目的の達成に必要とされる正確性・最新性を確保するために適切な措置を講じています。<br/>
            &nbsp;<br/>
            ５．個人情報保護法に基づく保有個人データの開示、訂正等、利用停止など<br/>
            個人情報保護法に基づく保有個人データに関する開示、訂正等または利用停止などに関するご請求については、ご本人であることを確認させていただいた上でご対応させていただきます。<br/>
            &nbsp;<br/>
            ６．法令等の遵守<br/>
            当協会は、個人情報の保護に関する法律（個人情報保護法）その他の関連法令および関係官庁のガイドライン等を遵守します。<br/>
            &nbsp;<br/>
            ７．見直し・改善<br/>
            当協会の個人情報の取扱いおよび安全管理に係る適切な措置については、適宜見直し、改善いたします。<br/>
            &nbsp;<br/>
            ８．お問い合わせ・ご相談・苦情へのご対応<br/>
            当協会は、個人情報の取扱いに関する苦情・ご相談に迅速にご対応いたします。ご連絡先は下記のお問い合わせ窓口となります。なお、ご照会者がご本人であることを確認させていただいた上で、ご対応させていただきますので、あらかじめご了承願います。<br/>
            &nbsp;<br/>
            【団体名】 　〔 一般社団法人 日本ワーキング・ホリデー協会 〕<br/>
            【所在地】 　 〔 〒160-0023 東京都新宿区西新宿1-3-3 品川ステーションビル新宿5階507 〕<br/>
            【電話番号】 〔 03-6304-5858 〕	<br/>
            &nbsp;<br/>
            以上<br/></p>		
    </div><!-- /content -->

</div><!-- /page privacy-policy -->

<div data-role="page" id="visa-suport">

    <div data-role="header" data-theme="b">
        <h1>メンバー登録</h1>
    </div><!-- /header -->

    <div data-role="content" data-theme="b" class="info">	
        <p>
            「ビザ申請に関する重要事項」<br/>
            &nbsp;<br/>
            一般社団法人日本ワーキング・ホリデー協会（以下、当協会という）では、皆様のビザ（査証）申請に当り、以下の様な宣言をします。<br/>
            &nbsp;<br/>
            １．ビザ申請のサポートとはビザの発給を保証するものではなく、ビザの審査、発給に関しては各移民局、大使館が行うものであり、当協会にて審査、発行を行っている訳ではありません。<br/>
            よって、ビザの審査期間、発給時期、発給期間等の保証は一切しません。<br/>
            &nbsp;<br/>
            ２．原則、ビザ申請は申請者本人で行うものであり、当協会ではビザの代行申請を行っていません。<br/>
            万が一希望された場合でも、申請者本人の承諾かつ、当協会サポートの元、申請者本人にて申請するものであり、当協会では一切の責任を負いません。<br/>
            また、ビザ申請必要書類に関しては作成方法等の案内や添削のサポートを行うが、作成代行を行うものではありません。<br/>
            &nbsp;<br/>
            ３．当協会のビザ申請サポート前にご自身でビザ申請をした場合の、不許可通知、追加申請等のトラブルに関しての対応、サポートは一切できません。<br/>
            メンバー登録後、このような事例が発覚した際には、会員登録を解除します。なお、この場合のメンバー登録料は返金しません。<br/>
            &nbsp;<br/>
            ４．ビザ申請サポートに関しては申請者本人からの依頼があり行うものであり、その申し出が遅れたために申請期間に間に合わない、または定員達してしまった場合等の保証は一切できません。<br/>
            また、ビザ申請サポートが途中であっても、申請者本人からの連絡がなく申請者本人が放置した場合、当協会は一切の責任を負いません。<br/>
            &nbsp;<br/>
            ５．ビザ申請サポートに関して、虚偽の申請または内容の漏れや間違いなどが発覚した場合にはサポートが出来ません。<br/>
            また、ビザ申請に対して、移民局、大使館より追加書類や面接を求められた場合も代行は出来できませんので、申請者本人にて対応する必要があります。<br/>
            &nbsp;<br/>

            以上<br/>
        </p>
    </div><!-- /content -->

</div><!-- /page visa-support -->