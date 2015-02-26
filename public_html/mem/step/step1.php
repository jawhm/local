<div style="padding-left:30px; float:clear;">

    <!--
    
            <p style="margin:20px 20px 16px 0; padding: 5px 0 5px 10px; font-size:11pt; font-weight:bold; background-color:aqua; color:navy;">
                    メンバー登録とは
            </p>
            <p style="margin:10px 0 8px 0; font-size:10pt; float:clear;">
                    メンバー登録とは、日本ワーキング・ホリデー協会によるワーホリ成功の為のメンバーサポート制度です。<br/>
                    メンバーになると個別カウンセリングや特別セミナーへの参加、ビザ取得サポート、出発前の準備、到着後のサポートまで個別にフルサポート致します。<br/>
                    <span style="color:red;">●</span>　メンバー登録料は５，０００円（３年間有効）となります。<br/>
            </p>
    -->

    <p class="title_bar">
        お客様情報をご入力下さい　　　　　　　<span style="font-size:8pt; font-weight:normal; color:black;"><img src="images/hissu.gif">　は必須項目です</span>
    </p>

    <form class="cmxform" id="signupForm" method="post" action="./check.php?k=<?php echo $k; ?>" onsubmit="fncClearFields();">
        <input type="hidden" name="act" value="<?php echo $act; ?>">
        <input type="hidden" name="kyoten" value="<?php echo $k; ?>">
        <table class="entrytable">
            <tr>
                <td class="td_flag">
                    <img src="images/hissu.gif">
                </td>
                <td class="td_tag">
                    メールアドレス
                </td>
                <td class="td_method">[半角英数字]</td>
                <td class="td_input">
                    <input id="email" name="email" size="36" maxlength="80" value="" class="focus" pre="0" />
                    &nbsp;
                    <span class="tooltip">
                        <img style="cursor:pointer;" src="images/hatena.gif" />
                        <div class="tooltipmsg">
                            ※ログイン用のメールアドレスとなります<br/>
                            ※携帯電話でのメールアドレスをご使用の場合、<br/>　jawhm.or.jpドメインからのメールを受信できるように設定を確認してください<br/>
                            ※次のようなメールアドレスはご利用いただけません。<br/>
							　１．メールアドレスの @ の直前にピリオド (.) がある<br/>
							　２． @ より前でピリオドが連続する<br/>
							　恐れ入りますが、他のメールアドレスでご登録ください。<br/>
                        </div><br/>
                    </span>
                    <span class="sample">例） mail@jawhm.or.jp</span>
                    <div class="postcode">
                        ※ご確認のメールをお送りしますので、連絡可能なメールアドレスを入力してください。
                    </div>
                </td>
            </tr>
            <?php if ($k == '') { ?>
                <tr>
                    <td class="td_flag">
                        <img src="images/hissu.gif">
                    </td>
                    <td class="td_tag">
                        パスワード
                    </td>
                    <td class="td_method">[半角英数字]</td>
                    <td class="td_input">
                        <div class="postcode">
                            ※登録後、メンバー専用ページへのログインの際に必要となります。<br/>
                        </div>
                        <input id="password" name="password" type="password" maxlength="20" />
                        &nbsp;
                        <span class="tooltip">
                            <img style="cursor:pointer;" src="images/hatena.gif" />
                            <div class="tooltipmsg">
                                ※メンバー専用ページにログインする際のパスワードとなります。<br/>
                            </div>
                        </span>
                        <div class="postcode">
                            ※半角英数字５～２０文字で入力してください。
                        </div>
                        <input id="confirm_password" name="confirm_password" type="password" maxlength="20" />
                        <div class="postcode">
                            ※確認の為、同じパスワードを入力してください。
                        </div>
                    </td>
                </tr>
            <?php } else { ?>
                <input id="password" name="password" type="hidden" maxlength="20" value="<?php echo $newpwd; ?>" />
                <input id="confirm_password" name="confirm_password" type="hidden" maxlength="20" value="<?php echo $newpwd; ?>" />
            <?php } ?>
            <tr>
                <td class="td_flag">
                    <img src="images/hissu.gif">
                </td>
                <td class="td_tag">
                    お名前
                </td>
                <td class="td_method">[全角]</td>
                <td class="td_input">
                    <table class="dummy">
                        <tr>
                            <td style="vertical-align:top;">
								　姓 <input id="namae1" name="namae1" maxlength="20" size="10" value="" class="focus" pre="0" />
                            </td>
                            <td style="vertical-align:top;">
								　　名 <input id="namae2" name="namae2" maxlength="20" size="10" value="" class="focus" pre="0" />
                            </td>
                            <td style="vertical-align:top;">　様</td>
                        </tr>
                        <td>
                            <span class="sample">　　例） 山田</span>
                        </td>
                        <td>
                            <span class="sample">　　例） 太郎</span>
                        </td>
            </tr>
        </table>
        </td>
        </tr>
        <tr>
            <td class="td_flag">
                <img src="images/hissu.gif">
            </td>
            <td class="td_tag">
                フリガナ
            </td>
            <td class="td_method">[全角カナ]</td>
            <td class="td_input">
                <table class="dummy">
                    <tr>
                        <td style="vertical-align:top;">
                            セイ <input id="furigana1" name="furigana1" maxlength="20" size="10" value="" class="focus" pre="0" />
                        </td>
                        <td style="vertical-align:top;">
								　メイ <input id="furigana2" name="furigana2" maxlength="20" size="10" value="" class="focus" pre="0" />
                        </td>
                        <td style="vertical-align:top;">　サマ</td>
                    </tr>
                    <td>
                        <span class="sample">　　例） ヤマダ</span>
                    </td>
                    <td>
                        <span class="sample">　　例） タロウ</span>
                    </td>
        </tr>
        </table>
        </td>
        </tr>
        <tr>
            <td class="td_flag">
                <img src="images/hissu.gif">
            </td>
            <td class="td_tag">
                性別
            </td>
            <td class="td_method"></td>
            <td class="td_input">
                <input type="radio" id="gender_male" value="m" name="gender" validate="required:true" />男性 &nbsp;&nbsp;
                <input type="radio" id="gender_female" value="f" name="gender" checked/>女性
                <label for="gender" class="error">性別を選択してください</label>
            </td>
        </tr>
        <tr>
            <td class="td_flag">
                <img src="images/hissu.gif">
            </td>
            <td class="td_tag">
                生年月日
            </td>
            <td class="td_method"></td>
            <td class="td_input">
                <select id="y" name="year">
                    <?php
                    for ($i = 1970; $i <= date('Y'); $i++) {
                        echo '<option value="' . $i . '"';
                        if ($i == (date('Y') - 22))
                            echo'selected';

                        echo '>' . $i . '</option>';
                    }
                    ?>                            
                </select>年
                <select id="m" name="month">
                    <option value="">--</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option>
                </select>月
                <select id="d" name="day">
                    <option value="">--</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option><option value="31">31</option>
                </select>日
                <img src="./images/icon_calendar.gif" id="select_date_calendar_icon"/>
                &nbsp;
                <span class="tooltip">
                    <img style="cursor:pointer;" src="images/hatena.gif" />
                    <div class="tooltipmsg">
                        ※カレンダーアイコンをクリックして簡単に選択して頂くこともできます。
                    </div>
                </span>
            </td>
        </tr>
        <tr>
            <td class="td_flag">
                <img src="images/hissu.gif">
            </td>
            <td class="td_tag">
                郵便番号
            </td>
            <td class="td_method">[半角数字]</td>
            <td class="td_input">
                <input id="pcode" name="pcode" size=10 maxlength="10" value="" class="focus" pre="0" onKeyUp="AjaxZip2.zip2addr(this, 'add1', 'add2', null, 'add2');" />
                <span class="sample">例） 160-0023</span>
                <div class="postcode">
                    郵便番号をご入力頂くと、ご住所が自動で入力されます。　<span style="color:red;">[ <a target="_new" href="http://www.post.japanpost.jp/zipcode/" tabindex="-1">〒郵便番号検索ページへ</a> ]</span>
                </div>
            </td>
        </tr>
        <tr style="border-top:none;">
            <td class="td_flag">
                <img src="images/hissu.gif">
            </td>
            <td class="td_tag">
                都道府県
            </td>
            <td class="td_method">[全角]</td>
            <td class="td_input">
                <input id="add1" name="add1" size=20 maxlength="80" value="" class="focus" pre="0" /><br/><span class="sample">例） 東京都</span>
            </td>
        </tr>
        <tr style="border-top:none;">
            <td class="td_flag">
                <img src="images/hissu.gif">
            </td>
            <td class="td_tag">
                市区町村
            </td>
            <td class="td_method">[全角]</td>
            <td class="td_input">
                <input id="add2" name="add2" size=50 maxlength="80" value="" class="focus" pre="0" /><br/><span class="sample">例） 新宿区西新宿</span>
            </td>
        </tr>
        <tr style="border-top:none;">
            <td class="td_flag">
                <img src="images/hissu.gif">
            </td>
            <td class="td_tag">
                番地・建物名
            </td>
            <td class="td_method">[全角]</td>
            <td class="td_input">
                <input id="add3" name="add3" size=50 maxlength="80" value="" class="focus" pre="0" />
                &nbsp;
                <span class="tooltip">
                    <img style="cursor:pointer;" src="images/hatena.gif" />
                    <div class="tooltipmsg">
                        ※海外からの場合、国名を「都道府県」の欄に入力し<br/>
							　残りの住所を「市区町村」「番地・建物名」に入力してください<br/>
                    </div>
                </span>
                <br/><span class="sample">例） １－３－３　ステーションビル５０７</span>
                <div class="postcode">
                    ※メンバーズカードをお送りします。<br/>
						　宛先不明でカードがお送り出来ない事が多くあります。必ず<b>アパート・マンション名など</b>も入力してください。<br/>
                </div>
            </td>
        </tr>
        <tr>
            <td class="td_flag">
                <img src="images/hissu.gif">
            </td>
            <td class="td_tag">
                電話番号
            </td>
            <td class="td_method">[半角数字]</td>
            <td class="td_input">
                <input id="tel" name="tel" maxlength="30" value="" class="focus" pre="0" />
                <br/><span class="sample">例） 0363045858</span>
                <div class="postcode">
                    ※ハイフンは<b>入力不要</b>です。
                </div>
            </td>
        </tr>

        <tr>
            <td class="td_flag">
            </td>
            <td class="td_tag">
                今後のご案内
            </td>
            <td class="td_method"></td>
            <td class="td_input">
                今後、セミナーやイベントのご案内等をお送りしてもよろしいですか？<br/>
                <input type="radio" class="radio" name="mailsend" value="1" checked>&nbsp;受け取る
                &nbsp;&nbsp;
                <input type="radio" class="radio" name="mailsend" value="0">&nbsp;受け取らない
            </td>
        </tr>

        <tr>
            <td class="td_flag">
                <img src="images/hissu.gif">
            </td>
            <td class="td_tag">
                メンバー規約と<br/>プライバシーポリシー
            </td>
            <td class="td_method"></td>
            <td class="td_input">
                【　メンバー規約　】
                <iframe src="kiyaku1.html" style="height:160px; width:100%; border:1px solid gray;"></iframe>

                【　プライバシーポリシー　】
                <iframe src="kiyaku2.html" style="height:160px; width:100%; border:1px solid gray;"></iframe>

                &nbsp;<br/>
                <input type="checkbox" class="checkbox" id="agree" name="agree" value="同意" />&nbsp;&nbsp;「メンバー規約」に同意し、「プライバシーポリシー」を確認しました。<br/>
                &nbsp;<br/>
            </td>
        </tr>

        </table>

        <input type="submit" value="次へ >>" style="width:150px; height:30px; margin:18px 0 30px 600px; font-size:11pt; font-weight:bold;" />

    </form>


</div>

<script type="text/javascript">
    SelectCalendar.createOnLoaded({yearSelect: 'y',
        monthSelect: 'm',
        daySelect: 'd'
    },
    {
        startYear: 1970,
        endYear: <?php echo date('Y'); ?>,
        lang: 'ja',
        triggers: ['select_date_calendar_icon']
    });
</script>
