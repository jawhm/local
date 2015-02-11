<?php

session_start();

$output = "";

function get_select_countries()
{
	$countries = array(
		'オーストラリア',
		'ニュージーランド',
		'カナダ',
		'韓国',
		'フランス',
		'ドイツ',
		'イギリス',
		'アイルランド',
		'デンマーク',
		'ノルウェー',
		'台湾',
		'香港',
		'未定',
	);

	$output = "";
	$output .= '
	<style type="text/css">
#countries_checkbox label {
  display: inline-block;
  padding-right: 20px;
}
</style>
	<div id="countries_checkbox">
';
	foreach ($countries as $one) {
		$output .= '<label><input type="checkbox" name="興味国[]" value="' . $one . '">&nbsp;' . $one . '</label>';
	}
	$output .= '</div>';

	return $output;
}

function get_select_yotei()
{
	$yotei = array(
		'3ヶ月以内',
		'6ヶ月以内',
		'1年以内',
		'2年以内',
		'未定',
	);

	$output = "";
	$output .= '
<select name="出発時期">
	<option value="">選択してください</option>
';
	foreach ($yotei as $one) {
		$output .= '<option value="' . $one . '">' . $one . '</option>';
	}
	$output .= "</select>";
	return $output;
}

if (@$_SESSION['mem_id'] != '') {

	$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);
	$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$db->query('SET CHARACTER SET utf8');
	$stt = $db->prepare('SELECT id, email, namae, furigana, tel, country FROM memlist WHERE id = :id ');
	$stt->bindValue(':id', $_SESSION['mem_id']);
	$stt->execute();
	$member_info = $stt->fetch();

	$output .= '
		<tr>
			<td nowrap style="border-bottom: 1px dotted pink; text-align:right;">お名前&nbsp;</td>
			<td style="border-bottom: 1px dotted pink; text-align:left;">' . $member_info['namae'] . '　様
				<input type="hidden" name="お名前" id="txt_name" value="' . $member_info['namae'] . '" size=20>
				<input type="hidden" name="フリガナ" id="txt_furigana" value="' . $member_info['furigana'] . '" size=20>
				<input type="hidden" name="メール" id="txt_mail" value="' . $member_info['email'] . '" size=40><br/>
				<input type="hidden" name="電話番号" id="txt_tel" value="' . $member_info['tel'] . '" size=20>
			</td>
		</tr>
		<tr style="background-color:white;">
			<td nowrap style="border-bottom: 1px dotted pink; text-align:right;">興味のある国&nbsp;</td>
			<td style="border-bottom: 1px dotted pink; text-align:left;">
				' . get_select_countries($member_info['country']) . '
			</td>
		</tr>
		<tr>
			<td nowrap style="border-bottom: 1px dotted pink; text-align:right;">出発予定時期&nbsp;</td>
			<td style="border-bottom: 1px dotted pink; text-align:left;">
			' . get_select_yotei() . '
			</td>
		</tr>
		<tr style="background-color:white;">
			<td nowrap style="text-align:right;">その他&nbsp;</td>
			<td style="text-align:left;"><input type="text" name="その他" id="txt_memo" value="" size=50></td>
		</tr>';
} else {
	$output = '
		<tr>
			<td nowrap style="border-bottom: 1px dotted pink; text-align:right;">お名前&nbsp;</td>
			<td style="border-bottom: 1px dotted pink; text-align:left;">
				(氏)<input type="text" name="お名前" id="txt_name" value="" size=10>
				(名)<input type="text" name="お名前2" id="txt_name2" value="" size=10>
			</td>
		</tr>
		<tr>
			<td nowrap style="border-bottom: 1px dotted pink; text-align:right;">フリガナ&nbsp;</td>
			<td style="border-bottom: 1px dotted pink; text-align:left;">
				(氏)<input type="text" name="フリガナ" id="txt_furigana" value="" size=10>
				(名)<input type="text" name="フリガナ2" id="txt_furigana2" value="" size=10>
			</td>
		</tr>
		<tr style="background-color:white;">
			<td nowrap valign="top" style="border-bottom: 1px dotted pink; text-align:right;">メールアドレス&nbsp;</td>
			<td style="border-bottom: 1px dotted pink; text-align:left;">
				<input type="text" name="メール" id="txt_mail" value="" size=40><br/>
				<span style="font-size:8pt;">
				※予約確認のメールをお送りします。必ず有効なアドレスを入力してください。<br/>
				</span>
			</td>
		</tr>
		<tr>
			<td nowrap style="border-bottom: 1px dotted pink; text-align:right;">当日連絡の付く電話番号&nbsp;</td>
			<td style="border-bottom: 1px dotted pink; text-align:left;"><input type="text" name="電話番号" id="txt_tel" value="" size=20></td>
		</tr>
		<tr style="background-color:white;">
			<td nowrap style="border-bottom: 1px dotted pink; text-align:right;">興味のある国&nbsp;</td>
			<td style="border-bottom: 1px dotted pink; text-align:left;">
			' . get_select_countries() . '
			</td>
		</tr>
		<tr>
			<td nowrap style="border-bottom: 1px dotted pink; text-align:right;">出発予定時期&nbsp;</td>
			<td style="border-bottom: 1px dotted pink; text-align:left;">
			' . get_select_yotei() . '
			</td>
		</tr>
		<tr>
			<td nowrap valign="top" style="border-bottom: 1px dotted pink; text-align:right;">同伴者有無&nbsp;</td>
			<td style="border-bottom: 1px dotted pink; text-align:left;">
				<input type="checkbox" name="同伴者" id="txt_dohan"> 同伴者あり<br/>
				<span style="font-size:8pt;">
				　　※同伴者ありの場合、２人分の席を確保致します。<br/>
				　　※３名以上でご参加の場合は、メールにてご連絡ください。<br/>
				</span>
			</td>
		</tr>
		<tr>
			<td nowrap style="border-bottom: 1px dotted pink; text-align:right;">今後のご案内&nbsp;</td>
			<td style="border-bottom: 1px dotted pink; text-align:left;"><input type="checkbox" name="メール会員" id="txt_mailmem" checked> このメールアドレスをメール会員(無料)に登録する</td>
		</tr>
		<tr style="background-color:white;">
			<td nowrap style="text-align:right;">その他&nbsp;</td>
			<td style="text-align:left;"><input type="text" name="その他" id="txt_memo" value="" size=50></td>
		</tr>';
}

echo $output;

