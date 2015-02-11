<?php
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
	$gmn_id = 'M-kbt_counseling_kkn.php';
	//遷移ＯＫとする遷移元の画面ＩＤ
	$ok_gmn = array('M-kbt_counseling_menu.php','M-kbt_counseling_can1.php','M-kbt_counseling_select_date.php');

	$err_flg = 0;	//0:エラーなし　1:サーバー接続エラー　2:画面遷移エラー　3:引数エラー　4以降は画面毎に設定

	$tabindex = 0;	//タブインデックス

	//日付関係
	require( '../zz_datetime.php' );

	mb_language("Ja");
	mb_internal_encoding("utf8");

	//***コーディングはここから**********************************************************************************

	//引数の入力
	$prc_gmn = $_POST['prc_gmn'];
	$lang_cd = $_POST['lang_cd'];
	$yykkey_ang_str = $_POST['yykkey_ang_str'];
	$kaiin_id = $_POST['kaiin_id'];
	$kaiin_nm = $_POST['kaiin_nm'];
	$kaiin_kbn = $_POST['kaiin_kbn'];
	$select_yyk_no = $_POST['select_yyk_no'];
	
	//サーバー接続
	require( './zm_svconnect.php' );
	
	//接続結果
	if( $svconnect_rtncd == 1 ){
		$err_flg = 1;
	}else{
		//画面ＩＤのチェック
		if( !in_array($prc_gmn , $ok_gmn) ){
			$err_flg = 2;
		}else{
			//引数入力チェック
			if ( $lang_cd == "" || $yykkey_ang_str == "" || $kaiin_id == "" || $kaiin_nm == "" || $kaiin_kbn == "" || $select_yyk_no == "" ){
				$err_flg = 3;
			}else{
				//メンテナンス期間チェック
				require( '../yoyaku/zy_mntchk.php' );
		
				if( $mntchk_flg == 1 || $mntchk_flg == 2 ){
					$err_flg = 80;	//メンテナンス中
				}
			}
		}
	}
	

	//エラー発生時
	if( $err_flg != 0 ){
		//エラー画面編集
		require( './zm_errgmn.php' );
		
	}else{

		//ページ編集

		//ユーザーエージェント
		require( './zm_uachk.php' );
		
		//画像事前読み込み
		if( !($mobile_kbn == 'D' || $mobile_kbn == 'U' || $mobile_kbn == 'S' || $mobile_kbn == 'W') ){
			//スマホのみ
			print('<center>');
			print('<table border="0">');
			print('<tr>');
			print('<td width="185" align="left">');
			print('<img src="./img_' . $lang_cd . '/btn_menu_2.png" width="0" height="0" style="visibility:hidden;">');
			print('<img src="./img_' . $lang_cd . '/btn_date_change_2.png" width="0" height="0" style="visibility:hidden;">');
			print('<img src="./img_' . $lang_cd . '/btn_cancel_2.png" width="0" height="0" style="visibility:hidden;">');
			print('<img src="./img_' . $lang_cd . '/btn_modoru_2.png" width="0" height="0" style="visibility:hidden;">');
			print('</td>');
			//メニューへ戻るボタン
			print('<td width="135" align="right" valign="middle">');
			if( $mobile_kbn == 'I' ){
				//iPhoneのみ
				print('<form method="post" action="' . $sv_https_adr . 'yoyaku_mb/M-kbt_counseling_menu.php#kbtcounseling">');
			}else{
				print('<form method="post" action="' . $sv_https_adr . 'yoyaku_mb/M-kbt_counseling_menu.php">');
			}
			print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
			print('<input type="hidden" name="yykkey_ang_str" value="' . $yykkey_ang_str . '">');
			$tabindex++;
			print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_menu_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_menu_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_menu_1.png\';" border="0">');
			print('</form>');
			print('</td>');
			print('</tr>');
			print('</table>');
			print('</center>');
			
		}

		//予約内容を取得する
		$zz_yykinfo_yyk_no = $select_yyk_no;
		require( '../zz_yykinfo.php' );
		if( $zz_yykinfo_rtncd == 1 ){
			$err_flg = 4;
			//エラーメッセージ表示
			require( './zm_errgmn.php' );
			
			//**ログ出力**
			$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
			$log_kkstaff_kbn = 'K';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
			$log_office_cd = '';			//オフィスコード
			$log_kaiin_no = $kaiin_id;		//会員番号 または スタッフコード
			$log_naiyou = '予約内容の取り込みに失敗しました。';	//内容
			$log_err_inf = '予約番号[' . $select_yyk_no . ']';	//エラー情報
			require( './zm_log.php' );
			//************
			
		}else if( $zz_yykinfo_rtncd == 8 ){
			//予約が無くなった
			$err_flg = 5;	//予約が無くなった
		
		}
		

		if( $err_flg == 0 ){

			//画面編集
			print('<center>');

			//*** 携帯電話（スマホ以外） ************************************************************************************
			if( $mobile_kbn == 'D' || $mobile_kbn == 'U' || $mobile_kbn == 'S' || $mobile_kbn == 'W' ){
				//携帯電話（スマホ以外）
				
				//テスト中メッセージ
				if( $SVkankyo == 9 ){
					print('<table border="0"><tr><td width="320" align="center" bgcolor="#FF0099"><font color="white">*** 現在、テスト中です。 ***</font></td></tr></table>');
				}

				print('<br><font size="2" color="red">※お使いの機種では、<br>現在ご利用できません。</font><br><br><font size="1" color="blue">パソコンから予約できます</font>');
				
//print('<input type="submit" name="button" style="padding: 10px 10px 10px 10px;" value="予約する">');
				
			//*** スマホ ************************************************************************************
			}else{
				//スマホ
				
				//テスト中メッセージ
				if( $SVkankyo == 9 ){
					print('<table border="0"><tr><td width="320" align="center" bgcolor="#FF0099"><font color="white">*** 現在、テスト中です。 ***</font></td></tr></table>');
				}
	
				print('<table border="0">');	//main
				print('<tr>');	//main
				print('<td width="320" aling="left valign="top">');	//main
			
				//「個別カウンセリング」
				print('<img src="./img_' . $lang_cd . '/bar_kbt_counseling.png" id="kbtcounseling" border="0"><br>');
				
				//お客様氏名
				print('<font size="4">' . $kaiin_nm . '</font>&nbsp;様<br>');
			
				print('<hr>');

				//「個別カウンセリングの予約内容です」
				//print('<img src="./img_' . $lang_cd . '/title_kbt_yykinfo.png" border="0"><br>');
				print('<center>');
				print('<font color="blue">現在の予約内容です。</font><br>');
				print('</center>');

				print('<table border="1" bordercolor="black">');
				print('<tr>');
				print('<td width="80" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_pink_80x20.png"><img src="./img_' . $lang_cd . '/title_mini_yykno.png" border="0"></td>');
				print('<td width="235" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_pink_235x20.png"><font color="blue" size="4">' . sprintf("%05d",$select_yyk_no) . '</font></td>');
				print('</tr>');
				print('<tr>');
				print('<td width="80" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_mizu_80x20.png"><img src="./img_' . $lang_cd . '/title_mini_kaijyou.png" border="0"></td>');
				print('<td width="235" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_mizu_235x20.png"><font size="4">' . $zz_yykinfo_office_nm . '</font></td>');
				print('</tr>');
				print('<tr>');
				print('<td width="80" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_mizu_80x20.png"><img src="./img_' . $lang_cd . '/title_mini_counselor_78x20.png" border="0"></td>');
				print('<td width="235" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_mizu_235x20.png">');
				if( $zz_yykinfo_staff_cd != "" ){
					print( $zz_yykinfo_open_staff_nm );
				}else{
					print('(指名なし)');
				}
				print('</td>');
				print('</tr>');
				print('<tr>');
				print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_kimidori_80x20.png"><img src="./img_' . $lang_cd . '/title_mini_nichiji.png" border="0"></td>');
				if( $zz_yykinfo_eigyoubi_flg == 1 || $zz_yykinfo_youbi_cd == 0 ){
					$fontcolor = "red";	//祝日/日曜
				}else if( $zz_yykinfo_youbi_cd == 6 ){
					$fontcolor = "blue";	//土曜
				}else{
					$fontcolor = "black";	//平日
				}
				print('<td align="center" valign="bottom" background="../img_' . $lang_cd . '/bg_kimidori_235x20.png"><font size="2" color="' . $fontcolor . '">' . substr($zz_yykinfo_ymd,0,4) . '</font><font size="1" color="' . $fontcolor . '">&nbsp;年</font>&nbsp;<font size="4" color="' . $fontcolor . '">' . sprintf("%d",substr($zz_yykinfo_ymd,5,2)) . '</font><font size="1" color="' . $fontcolor . '">&nbsp;月</font>&nbsp;<font size="4" color="' . $fontcolor . '">' . sprintf("%d",substr($zz_yykinfo_ymd,8,2)) . '</font><font size="1" color="' . $fontcolor . '">&nbsp;日</font>&nbsp;<font size="4" color="' . $fontcolor . '">' . $week[$zz_yykinfo_youbi_cd] . '</font><font size="1" color="' . $fontcolor . '">&nbsp;曜日</font><br><font size="4">' . intval($zz_yykinfo_st_time / 100) . ':' . sprintf("%02d",($zz_yykinfo_st_time % 100)) . '&nbsp;-&nbsp;' . intval($zz_yykinfo_ed_time / 100) . ':' . sprintf("%02d",($zz_yykinfo_ed_time % 100)) . '</font></td>');
				print('</tr>');
				//興味のある国
//				print('<tr>');
//				print('<td width="80" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_yellow_80x20.png"><img src="./img_' . $lang_cd . '/title_mini_kyoumi.png" border="0"></td>');
//				print('<td width="235" align="left" valign="middle" background="../img_' . $lang_cd . '/bg_yellow_235x20.png"><font size="2">&nbsp;&nbsp;' . $yyk_kyoumi . '</font></td>');
//				print('</tr>');
				//出発予定時期
//				print('<tr>');
//				print('<td width="80" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_yellow_80x20.png"><img src="./img_' . $lang_cd . '/title_mini_jiki.png" border="0"></td>');
//				print('<td width="235" align="left" valign="middle" background="../img_' . $lang_cd . '/bg_yellow_235x20.png"><font size="2">&nbsp;&nbsp;' . $yyk_jiki . '</font></td>');
//				print('</tr>');
				print('<tr>');
				print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_yellow_80x20.png"><img src="./img_' . $lang_cd . '/title_mini_soudannaiyou.png" border="0"></td>');
				print('<td align="left" valign="top" background="../img_' . $lang_cd . '/bg_yellow_235x20.png">');
				if( $zz_yykinfo_soudan != "" ){
					print('<font size="1"><div style="margin: 10px"><pre>' . $zz_yykinfo_soudan . '</pre></div></font>');
				}else{
					//未登録（スタッフ画面からは未入力可能）
					print('<table border="0"><tr><td width="235" align="center"><font color="gray">未登録</font></td></tr></table>');
				}
				print('</td>');
				print('</tr>');
				print('</table>');

				if( $zz_yykinfo_ymd > $now_yyyymmdd2 || ($zz_yykinfo_ymd == $now_yyyymmdd2 && $zz_yykinfo_st_time > (($now_hh * 100) + $now_ii) ) ){
					//日時変更／予約の取消 が可能
					print('<table border="0">');
					print('<tr>');
					print('<td width="110">&nbsp;</td>');
					//日時変更ボタン
					if( $mobile_kbn == 'I' ){
						//iPhoneのみ
						print('<form method="post" action="' . $sv_https_adr . 'yoyaku_mb/M-kbt_counseling_select_date.php#kbtcounseling">');
					}else{
						print('<form method="post" action="' . $sv_https_adr . 'yoyaku_mb/M-kbt_counseling_select_date.php">');
					}
					print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
					print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '">');
					print('<input type="hidden" name="yykkey_ang_str" value="' . $yykkey_ang_str . '">');
					print('<input type="hidden" name="kaiin_id" value="' . $kaiin_id . '">');
					print('<input type="hidden" name="kaiin_nm" value="' . $kaiin_nm . '">');
					print('<input type="hidden" name="kaiin_kbn" value="' . $kaiin_kbn . '">');
					print('<input type="hidden" name="select_office_cd" value="' . $zz_yykinfo_office_cd . '">');
					print('<input type="hidden" name="select_staff_cd" value="' . $zz_yykinfo_staff_cd . '">');
					print('<input type="hidden" name="select_yyk_no" value="' . $select_yyk_no . '">');
					print('<td width="100" align="center" valign="middle">');
					$tabindex++;
					print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_date_change_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_date_change_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_date_change_1.png\';" border="0">');
					print('</td>');
					print('</form>');
					//予約の取消ボタン
					print('<td width="100" align="center" valign="middle">');
					if( $mobile_kbn == 'I' ){
						//iPhoneのみ
						print('<form method="post" action="' . $sv_https_adr . 'yoyaku_mb/M-kbt_counseling_can1.php#kbtcounseling">');
					}else{
						print('<form method="post" action="' . $sv_https_adr . 'yoyaku_mb/M-kbt_counseling_can1.php">');
					}
					print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
					print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '">');
					print('<input type="hidden" name="yykkey_ang_str" value="' . $yykkey_ang_str . '">');
					print('<input type="hidden" name="kaiin_id" value="' . $kaiin_id . '">');
					print('<input type="hidden" name="kaiin_nm" value="' . $kaiin_nm . '">');
					print('<input type="hidden" name="kaiin_kbn" value="' . $kaiin_kbn . '">');
					print('<input type="hidden" name="select_yyk_no" value="' . $select_yyk_no . '">');
					$tabindex++;
					print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_cancel_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_cancel_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_cancel_1.png\';" border="0">');
					print('</form>');
					print('</td>');
					print('</tr>');
					print('</table>');
				
				}else{
					//変更できません
				
				}
			
				print('<hr>');

				print('<table border="0">');
				print('<tr>');
				print('<td width="185">&nbsp;</td>');
				//戻るボタン
				print('<td width="135" align="right" valign="middle">');
				if( $mobile_kbn == 'I' ){
					//iPhoneのみ
					print('<form method="post" action="' . $sv_https_adr . 'yoyaku_mb/M-kbt_counseling_menu.php#kbtcounseling">');
				}else{
					print('<form method="post" action="' . $sv_https_adr . 'yoyaku_mb/M-kbt_counseling_menu.php">');
				}
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<input type="hidden" name="yykkey_ang_str" value="' . $yykkey_ang_str . '">');
				$tabindex++;
				print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" border="0">');
				print('</form>');
				print('</td>');
				print('</tr>');
				print('</table>');

				print('</td>');	//main
				print('</tr>');	//main
				print('</table>');	//main
				
			}
			
			print('</center>');

			
		}else if( $err_flg == 5 ){
			//予約が無くなった
			print('<br><font size="2" color="red">予約が取消されていますので、始めからお願いします。</font><br><br>');
			
			print('<table border="0">');
			print('<tr>');
			print('<td width="185">&nbsp;</td>');
			//戻るボタン
			print('<td width="135" align="center" valign="middle">');
			if( $mobile_kbn == 'I' ){
				//iPhoneのみ
				print('<form method="post" action="' . $sv_https_adr . 'yoyaku_mb/M-kbt_counseling_menu.php#kbtcounseling">');
			}else{
				print('<form method="post" action="' . $sv_https_adr . 'yoyaku_mb/M-kbt_counseling_menu.php">');
			}
			print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
			print('<input type="hidden" name="yykkey_ang_str" value="' . $yykkey_ang_str . '">');
			$tabindex++;
			print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" border="0">');
			print('</form>');
			print('</td>');
			print('</tr>');
			print('</table>');
		
			print('<hr>');
			
		}
	}

	mysql_close( $link );


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