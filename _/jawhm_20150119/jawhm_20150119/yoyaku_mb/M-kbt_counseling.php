<?php

	session_start();

	ini_set( "display_errors", "Off");
	mb_language("Ja");
	mb_internal_encoding("utf8");
	
	// パラメータ確認
	$d = @$_GET['d'];

	// ログイン情報
	$mem_id = @$_SESSION['mem_id'];
	$mem_name = @$_SESSION['mem_name'];
	$mem_level = @$_SESSION['mem_level'];

require_once '../include/header.php';

$header_obj = new Header();

$header_obj->frontpage=false;

$header_obj->description_page='ワーキングホリデー（ワーホリ）協定国の最新のビザ取得方法や渡航情報などを発信しています。また、ワーキングホリデー（ワーホリ）をされる方向けの各種無料セミナーを開催しています。オーストラリア、ニュージーランド、カナダ、韓国、フランス、ドイツ、イギリス、アイルランド、デンマーク、台湾、香港でワーキングホリデー（ワーホリ）ビザの取得が可能です。ワーキングホリデー（ワーホリ）ビザ以外に学生ビザでの留学などもお手伝い可能です。';

$header_obj->add_js_files = '
<script src="https://www.google.com/jsapi?key=ABQIAAAA1GaXyTxfx_EDrRX444NPQhQ3fj4XOcTTnvyZdGafpHojXl1fMRSD3wXKQgd9LOOX8nS2J9CjTLfu7A" type="text/javascript"></script>
<script src="../js/top.js" type="text/javascript"></script>
';

$header_obj->pcredirect='/';
$header_obj->fncMenuHead_h1text = '日本ワーキング・ホリデー協会';
$header_obj->fncMenubar_advertisement='';
$header_obj->display_header();

?>
<?php
	//***共通情報************************************************************************************************
	//画面情報
	//当画面の画面ＩＤ
	$gmn_id = 'M-kbt_counseling.php';
	//遷移ＯＫとする遷移元の画面ＩＤ
	//オールOK

	$err_flg = 0;	//0:エラーなし　1:サーバー接続エラー　2:画面遷移エラー　3:引数エラー　4以降は画面毎に設定

	$tabindex = 0;	//タブインデックス

	//日付関係
	require( '../zz_datetime.php' );

	//祝日情報
	require_once('../jp-holiday.php');

	if( $now_youbi == 0 || $dt->is_jp_holiday == true ){
		//日曜・祝日
		$zs_youbi_color = 'red';
	}else if( $now_youbi == 6 ){
		//土曜
		$zs_youbi_color = 'blue';
	}else{
		//平日
		$zs_youbi_color = 'black';
	}

	mb_language("Ja");
	mb_internal_encoding("utf8");

	//***コーディングはここから**********************************************************************************

	//引数の入力
	$prc_gmn = $_POST['prc_gmn'];
	$lang_cd = 'J';

	//サーバー接続
	require( './zm_svconnect.php' );
	
	//接続結果
	if( $svconnect_rtncd == 1 ){
		$err_flg = 1;
	}else{
		//メンテナンス期間チェック
		require( './zm_mntchk.php' );

		if( $mntchk_flg == 1 || $mntchk_flg == 2 ){
			$err_flg = 80;	//メンテナンス中
		}
	}
	

	//エラー発生時
	if( $err_flg != 0 ){
		//エラー画面編集
		require( './zm_errgmn.php' );
		
	}else{

		if( $mem_id != "" ){
			//メンバー
			
			//お客様番号を求める
			// ＣＲＭに転送
			$data = array(
				 'pwd' => '303pittST'
				,'serch_id' => $mem_id
			);
			$url = 'https://toratoracrm.com/crm/CS_serch_id.php';
			$val = wbsRequest($url, $data);
			$ret = json_decode($val, true);
			if ($ret['result'] == 'OK')	{
				// OK
				$msg = $ret['msg'];
				$rtn_cd = $ret['rtn_cd'];
				$member_cnt = $ret['data_cnt'];
				if( $member_cnt == 1 ){
					//データが見つかった（１件のみ）
					
					$kaiin_id = $ret["data_id_0"];			//お客様番号
					$kaiin_nm = $ret["data_name_0"];			//氏名
//					$data_kaiin_nm_k = $ret["data_name_k_0"];			//フリガナ
//					$data_kaiin_mixi = $ret["data_mixi_0"];			//ＭＩＸＩ名
//					$data_kaiin_kyoumi = $ret["data_yotei_0"];		//予定国（興味のある国に設定）
//					$data_kaiin_bikou = $ret["data_bikou_0"];			//基本情報メモ（備考）
//					$tmp_mail = $ret["data_mail_0"];			//会員メールアドレス
//					$tmp_mail = str_replace(',','<br>',$tmp_mail );
//					$data_kaiin_mail = $tmp_mail;			//会員メールアドレス
//					$tmp_tel = $ret["data_tel_0"];			//会員電話番号
//					$data_kaiin_tel = str_replace(',','<br>',$tmp_tel );		//[,]を改行コードに置換する
//					$data_kaiin_tel_keitai = "";		//会員電話番号
//						
//					//会員名カナの調整
//					if( $data_kaiin_nm_k == "　" ){
//						$data_kaiin_nm_k = "";	
//					}
					
					//暗号化する
					$yykkey_kaiin_id = $kaiin_id;
					require( '../yoyaku/zy_yykkey_ang.php' );
					if( $yykkey_err_flg != 0 ){
						// NG	
						$err_flg = 6;	//暗号キー生成エラー
						
					}
					
				}else{
					// NG	
					$err_flg = 5;	//お客様番号を求められなかった
					
				}
					
			}else{
				// NG	
				$err_flg = 5;	//お客様番号を求められなかった
				
			}
			
		}

		
		if( $err_flg == 0 && $mem_id == "" ){
			//一般（無料メンバー）と判断

			//ページ編集
			print('<center>');
			
			//「※個別カウンセリングの予約について」
			print('<img src="./img_' . $lang_cd . '/title_kbt_main.png" border="0"><br>');
			
			//「下記のメールアドレスへ空メールを送信してください。」
			print('<img src="./img_' . $lang_cd . '/title_kbt_kakinomail.png" border="0"><br>');
		
			//「予約受付メールアドレス」
			print('<img src="./img_' . $lang_cd . '/title_yyk_uketsuke.png" border="0"><br>');
			print('<a href="mailto:' . $sv_yyk_request_mailadr . '?subject=Request&body=Request" style="text-decoration: none;"><font size="5" color="blue">' . $sv_yyk_request_mailadr . '</font></a><br>');

			print('<hr>');
			
			print('<font color="red" size="1">・初回の方は申し訳ありませんが、オフィスへご連絡ください。</font><br>');
			print('<font size="1">・事前に登録済みのメールアドレスで送信してください。</font><br>');
			print('<font size="1">（未登録の場合はオフィスへご連絡ください。）</font><br>');
			print('<font size="1">・自動的に 個別カウンセリングの予約ページのアドレスを送られてきたメールアドレス宛に返信します。</font><br>');
			print('<font size="1">（ ' . $sv_yyk_send_mailadr . ' から送信しますので、メールが受信できるようメール受信設定をお願いします。）</font><br>');
	
			print('<hr>');
	
			print('</center>');
			
		
		}else if( $err_flg == 0 && $mem_id != "" ){
			//メンバーと判断

			//ページ編集
			print('<center>');

			//画面編集
			//「下のログインボタンを押してください。」
			//print('<img src="./img_' . $lang_cd . '/title_kbt_main_login_1.png" border="0"><br>');
			print('<table border="0">');
			print('<tr>');
			print('<td align="left">');
			print('<font size="4" color="blue">個別カウンセリングの予約</font><br>');
			print('<font size="2">下のメニュー画面へボタンを押してください。</font><br>');
			print('<font size="1">（メンバー専用画面が表示されます）</font><br>');
			print('</td>');
			print('</tr>');
			print('</table>');
			
			print('<table border="0">');
			print('<tr>');
			print('<td width="320" align="center">');
			print('<form method="post" action="' . $sv_https_adr . 'yoyaku_mb/M-kbt_counseling_menu.php">');
			print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
			print('<input type="hidden" name="lang_cd" value="J">');
			print('<input type="hidden" name="yykkey_ang_str" value="' . $yykkey_ang_str . '">');
			$tabindex++;
			print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_kbt_menu_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_kbt_menu_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_kbt_menu_1.png\';" border="0">');
			print('</form>');
			print('</td>');
			print('</tr>');
			print('</table>');

			print('<br><br>');	//調整

			print('<hr>');

			print('</center>');
			
		}else if( $err_flg != 0 ){
			//エラー

			//画面編集
			//「エラーが発生しました。」
			print('<img src="./img_' . $lang_cd . '/title_kbt_main_err.png" border="0"><br>');

			print('<hr>');
			
		}
	}

	//画像事前読み込み
	print('<img src="./img_' . $lang_cd . '/btn_kbt_menu_2.png" width="0" height="0" style="visibility:hidden;">');

	function wbsRequest($url, $params)
	{
		$data = http_build_query($params);
		$content = file_get_contents($url.'?'.$data);
		return $content;
	}

?>

  </div><!--contentsEND-->
  </div><!--contentsboxEND-->

<?php
	fncMenuFooter($header_obj->footer_type);
?>
</body>
</html>