
<div data-role="page" id="step2" class="jquery">

    <div id="header-box">
        <h1>メンバー登録</h1>
    </div><!-- /header -->

    <div data-role="content" data-theme="b">
        <h2>STEP 2</h2>
        <h3>入力頂いた内容を確認の上、よろしければ「次へ」をクリックしてください。</h3>

        <?php //echo debug_array($final_array);	?>	

        <div data-role="fieldcontain" >
            <span class="listing-title">メールアドレス</span>
            <p><?php echo $final_array['email'] ?></p>
        </div>
        <div data-role="fieldcontain" >
            <span class="listing-title">お名前</span>
            <p><?php echo $final_array['name'] . '&nbsp;&nbsp;' . $final_array['firstname'] ?></p>
        </div>
        <div data-role="fieldcontain" >
            <span class="listing-title">ふりがな</span>
            <p><?php echo mb_convert_kana($final_array['phonetic_name'], 'KC') . '&nbsp;&nbsp;' . mb_convert_kana($final_array['phonetic_firstname'], 'KC') ?></p>
        </div>
        <div data-role="fieldcontain" >
            <span class="listing-title">性別</span>
            <p>
                <?php
                if ($final_array['gender'] == 'm')
                    echo '男性';
                else
                    echo '女性';
                ?>
            </p>
        </div>
        <div data-role="fieldcontain">
            <span class="listing-title">生年月日</span>
            <p><?php echo $final_array['select-choice-year'] . '年&nbsp;' . $final_array['select-choice-month'] . '月&nbsp;' . $final_array['select-choice-day'] . '日'; ?></p>
        </div>

        <div data-role="fieldcontain">
            <span class="listing-title">メールアドレス</span>
            <table cellspacing="10" border="0">
                <tr>
                    <td>郵便番号</td><td><?php echo $final_array['postcode'] ?></td>
                </tr>
                <tr>
                    <td>都道府県</td><td><?php echo $final_array['province'] ?></td>
                </tr>	
                <tr>
                    <td>市区町村</td><td><?php echo $final_array['municipality'] ?></td>
                </tr>	
                <tr>
                    <td>番地・建物名</td><td><?php echo $final_array['address'] ?></td>
                </tr>	
            </table>
        </div>
        <div data-role="fieldcontain" class="div-form">
            <span class="listing-title">電話番号</span>
            <p><?php echo $final_array['phonenumber'] ?></p>
        </div>
        <div data-role="fieldcontain" class="div-form">
            <span class="listing-title">今後のご案内</span>
            <p><?php
                if ($final_array['guide'] == '1')
                    echo '受け取る';
                else
                    echo '受け取らない';
                ?>
            </p>
        </div>

    </div><!-- /content -->

    <div data-role="content">
        <form name="step2form" method="post" action="check.php" data-ajax="false">

            <div data-role="fieldcontain" class="div-form">
                <span class="titlebar">アンケート</span>
                <span class="title">職業</span>
                <select name="occupation" id="occupation" data-native-menu="false" data-mini="true">
                    <option value="" data-placeholder="true">職業</option>
                    <option value="会社員" <?php if (html_entity_decode($field_value['occupation']) == '会社員') echo 'selected'; ?> >会社員</option>
                    <option value="派遣" <?php if (html_entity_decode($field_value['occupation']) == '派遣') echo 'selected'; ?>>派遣</option>
                    <option value="アルバイト" <?php if (html_entity_decode($field_value['occupation']) == 'アルバイト') echo 'selected'; ?>>アルバイト</option>
                    <option value="学生" <?php if (html_entity_decode($field_value['occupation']) == '学生') echo 'selected'; ?>>学生</option>
                    <option value="無職" <?php if (html_entity_decode($field_value['occupation']) == '無職') echo 'selected'; ?>>無職</option>
                    <option value="その他" <?php if (html_entity_decode($field_value['occupation']) == 'その他') echo 'selected'; ?>>その他</option>
                </select>
            </div>

            <div data-role="fieldcontain" class="div-form">
                <span class="title">渡航予定国</span>
                <select name="country[]" id="country" multiple="multiple" data-native-menu="false" data-mini="true">
                    <!--<option>渡航予定国</option>-->

                    <option value="オーストラリア" <?php if (substr_count(html_entity_decode($field_value['country']), 'オーストラリア') == 1) echo 'selected'; ?> >オーストラリア</option>

                    <option value="ニュージーランド" <?php if (substr_count(html_entity_decode($field_value['country']), 'ニュージーランド') == 1) echo 'selected'; ?>>ニュージーランド</option>

                    <option value="カナダ" <?php if (substr_count(html_entity_decode($field_value['country']), 'カナダ') == 1) echo 'selected'; ?>>カナダ</option>

                    <option value="韓国" <?php if (substr_count(html_entity_decode($field_value['country']), '韓国') == 1) echo 'selected'; ?>>韓国</option>

                    <option value="フランス" <?php if (substr_count(html_entity_decode($field_value['country']), 'フランス') == 1) echo 'selected'; ?>>フランス</option>

                    <option value="ドイツ" <?php if (substr_count(html_entity_decode($field_value['country']), 'ドイツ') == 1) echo 'selected'; ?>>ドイツ</option>

                    <option value="イギリス" <?php if (substr_count(html_entity_decode($field_value['country']), 'イギリス') == 1) echo 'selected'; ?>>イギリス</option>

                    <option value="アイルランド" <?php if (substr_count(html_entity_decode($field_value['country']), 'アイルランド') == 1) echo 'selected'; ?>>アイルランド</option>

                    <option value="デンマーク" <?php if (substr_count(html_entity_decode($field_value['country']), 'デンマーク') == 1) echo 'selected'; ?>>デンマーク</option>

                    <option value="台湾" <?php if (substr_count(html_entity_decode($field_value['country']), '台湾') == 1) echo 'selected'; ?>>台湾</option>

                    <option value="香港" <?php if (substr_count(html_entity_decode($field_value['country']), '香港') == 1) echo 'selected'; ?>>香港</option>

                    <option value="未定" <?php if (substr_count(html_entity_decode($field_value['country']), '未定') == 1) echo 'selected'; ?>>未定</option>

                </select>
            </div>

            <div data-role="fieldcontain" class="div-form">
                <span class="title">渡航予定国の語学力</span>
                <select name="language-skill" id="language-skill" data-native-menu="false" data-mini="true">
                    <option value="" data-placeholder="true">渡航予定国の語学力</option>                            
                    <option value="堪能" <?php if (html_entity_decode($field_value['language-skill']) == '堪能') echo'selected'; ?> >堪能</option>
                    <option value="日常会話" <?php if (html_entity_decode($field_value['language-skill']) == '日常会話') echo'selected'; ?>>日常会話</option>
                    <option value="挨拶程度" <?php if (html_entity_decode($field_value['language-skill']) == '挨拶程度') echo'selected'; ?>>挨拶程度</option>
                    <option value="全然できない" <?php if (html_entity_decode($field_value['language-skill']) == '全然できない') echo'selected'; ?>>全然できない</option>
                    <option value="その他" <?php if (html_entity_decode($field_value['language-skill']) == 'その他') echo'selected'; ?>>その他</option>
                </select>
            </div>

            <div data-role="fieldcontain" class="div-form">
                <span class="title">渡航目的</span>
                <select name="travel-purpose[]" id="travel-purpose" multiple="multiple" data-native-menu="false" data-mini="true">
                    <!-- <option>渡航目的</option>-->
                    <option value="観光" <?php if (substr_count(html_entity_decode($field_value['travel-purpose']), '観光') == 1) echo 'selected'; ?> >観光</option>
                    <option value="語学上達のため" <?php if (substr_count(html_entity_decode($field_value['travel-purpose']), '語学上達のため') == 1) echo 'selected'; ?> >語学上達のため</option>
                    <option value="将来のキャリアアップ" <?php if (substr_count(html_entity_decode($field_value['travel-purpose']), '将来のキャリアアップ') == 1) echo 'selected'; ?> >将来のキャリアアップ</option>
                    <option value="海外生活体験" <?php if (substr_count(html_entity_decode($field_value['travel-purpose']), '海外生活体験') == 1) echo 'selected'; ?> >海外生活体験</option>
                    <option value="現地調査" <?php if (substr_count(html_entity_decode($field_value['travel-purpose']), '現地調査') == 1) echo 'selected'; ?> >現地調査</option>
                    <option value="研究" <?php if (substr_count(html_entity_decode($field_value['travel-purpose']), '研究') == 1) echo 'selected'; ?> >研究</option>
                    <option value="その他" <?php if (substr_count(html_entity_decode($field_value['travel-purpose']), 'その他') == 1) echo 'selected'; ?> >その他</option>
                </select>
            </div>

            <div data-role="fieldcontain" class="div-form">
                <span class="title">どこで当協会を 知りましたか</span>
                <select name="know-how[]" id="know-how" multiple="multiple" data-native-menu="false" data-mini="true">
                    <!--<option>どこで当協会を 知りましたか</option>-->
                    <option value="協会ホームページ" <?php if (substr_count(html_entity_decode($field_value['know-how']), '協会ホームページ') == 1) echo 'selected'; ?> >協会ホームページ</option>
                    <option value="留学エージェントの紹介" <?php if (substr_count(html_entity_decode($field_value['know-how']), '留学エージェントの紹介') == 1) echo 'selected'; ?> >留学エージェントの紹介</option>
                    <option value="書籍・雑誌" <?php if (substr_count(html_entity_decode($field_value['know-how']), '書籍・雑誌') == 1) echo 'selected'; ?> >書籍・雑誌</option>
                    <option value="友人の紹介" <?php if (substr_count(html_entity_decode($field_value['know-how']), '友人の紹介') == 1) echo 'selected'; ?> >友人の紹介</option>
                    <option value="大使館の紹介" <?php if (substr_count(html_entity_decode($field_value['know-how']), '大使館の紹介') == 1) echo 'selected'; ?> >大使館の紹介</option>
                    <option value="学校の紹介" <?php if (substr_count(html_entity_decode($field_value['know-how']), '学校の紹介') == 1) echo 'selected'; ?> >学校の紹介</option>
                    <option value="その他" <?php if (substr_count(html_entity_decode($field_value['know-how']), 'その他') == 1) echo 'selected'; ?> >その他</option>
                </select>
            </div>
            <div data-role="fieldcontain" class="div-form">
                <span class="titlebar">今後のご案内</span>
                <span class="title">今後、セミナーやイベントのご案内等をお送りしてもよろしいですか？</span>
                <fieldset data-role="controlgroup" data-type="horizontal">
                    <input type="radio" name="guide" id="receive" value="1"  data-mini="true" <?php if ($field_value['guide'] == 1 || !isset($field_value['guide'])) echo 'checked'; ?> />
                    <label for="receive">受け取る</label>
                    <input type="radio" name="guide" id="not-receive" value="0"  data-mini="true" <?php if ($field_value['guide'] == 0 && isset($field_value['guide'])) echo 'checked'; ?> />
                    <label for="not-receive">受け取らない</label>
                </fieldset>
            </div>

            <div style="padding:5px 5px 5px 5px; border:1px solid black;margin-bottom:12px;">
                【メンバー登録の前に必ずご確認ください】<br>
                皆様のビザ取得にあたり、当協会が実施するお手伝い（サポート）は、申請方法のご説明、書き方等の指導を行うものであり、申請を代行するものではありません。<br>
                各種ビザの発給は各国大使館・領事館等の判断によるものであり、当協会はビザ取得の確約、保障などは一切行えません。<br>
                ご自身でビザ申請した後のトラブル等の対応は、当協会では出来かねます。ご自身で直接申請先（大使館等）にお問い合わせ下さい。<br>
                また、お客様の状況によりサポートを御断りする場合も御座います。予めご了承ください。<br>
            </div>

            <div data-role="fieldcontain" class="div-form">
                <?php
                // Serialize the final array to be able to send it through form
                $serialize_array = serialize($final_array);
                ?>
                <input type="hidden" name="step" value="2" />
                <input type="hidden" name="final_array" value='<?php echo $serialize_array; ?>' />
                <a href="" type="button" data-theme="b" data-icon="back" data-rel="back" data-inline="true" />戻る</a>
                <input type="submit" value="次へ" data-theme="b" data-icon="check" data-inline="true" />
            </div>
        </form>

    </div><!-- /content -->

    <?php echo footer(); ?>

</div>