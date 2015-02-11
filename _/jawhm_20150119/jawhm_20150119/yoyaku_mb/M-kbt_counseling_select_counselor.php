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
	$gmn_id = 'M-kbt_counseling_select_counselor.php';
	//遷移ＯＫとする遷移元の画面ＩＤ
	$ok_gmn = array('M-kbt_counseling_select_top.php','M-kbt_counseling_select_date.php');

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
	$select_office_cd = $_POST['select_office_cd'];
	$select_staff_cd = $_POST['select_staff_cd'];		//未入力OK
	
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
			if ( $lang_cd == "" || $yykkey_ang_str == "" || $kaiin_id == "" || $kaiin_nm == "" || $kaiin_kbn == "" || $select_office_cd == "" ){
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
		require( '../yoyaku/zy_uachk.php' );

		//画像事前読み込み
		if( !($mobile_kbn == 'D' || $mobile_kbn == 'U' || $mobile_kbn == 'S' || $mobile_kbn == 'W') ){
			//スマホのみ
			print('<center>');
			print('<table border="0">');
			print('<tr>');
			print('<td width="185" align="left">');
			print('<img src="./img_' . $lang_cd . '/btn_menu_2.png" width="0" height="0" style="visibility:hidden;">');
			print('<img src="./img_' . $lang_cd . '/btn_next_2.png" width="0" height="0" style="visibility:hidden;">');
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

		$err_cnt = 0;
		$data_cnt = 0;
		
		
		//選択した会場（オフィス）を取得する
		$Moffice_cnt = 0;
		$query = 'select OFFICE_NM,START_YOUBI from M_OFFICE where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '";';
		$result = mysql_query($query);
		if (!$result) {
			$err_flg = 4;
			//エラーメッセージ表示
			require( './zm_errgmn.php' );
			
			//**ログ出力**
			$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
			$log_kkstaff_kbn = 'K';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
			$log_office_cd = '';			//オフィスコード
			$log_kaiin_no = $kaiin_id;		//会員番号 または スタッフコード
			$log_naiyou = 'オフィスマスタの参照に失敗しました。';	//内容
			$log_err_inf = $query;			//エラー情報
			require( './zm_log.php' );
			//************

		}else{
			while( $row = mysql_fetch_array($result) ){
				$Moffice_office_nm = $row[0];	//オフィス名
				$Moffice_start_youbi = $row[1];	//開始曜日  0:日曜始まり 1:月曜始まり
				
				//オフィスを会場に置換する
				$Moffice_office_nm = str_replace('オフィス','会場',$Moffice_office_nm );				
				
				$Moffice_cnt++;
			}
		}

		//基準日（今日の日曜日を基準日とする）
		$tag_yyyy = $now_yyyy;
		$tag_mm = $now_mm;
		if( $Moffice_start_youbi == 0 ){
			$tag_dd = $now_dd - $now_youbi;
		}else{
			$tag_dd = $now_dd - $now_youbi + 1;
		}
		if( $tag_dd <= 0 ){
			$tag_mm--;
			if( $tag_mm <= 0 ){
				$tag_mm = 12;
				$tag_yyyy--;
			}
			$tmp_maxdd = cal_days_in_month(CAL_GREGORIAN, $tag_mm , $tag_yyyy );
			$tag_dd = $tmp_maxdd + $tag_dd;
		}
		$tag_maxdd = cal_days_in_month(CAL_GREGORIAN, $tag_mm , $tag_yyyy );

		$disp_st_date = $tag_yyyy . sprintf("%02d",$tag_mm) . sprintf("%02d",$tag_dd);
		$disp_ed_date = date("Ymd", mktime(0, 0, 0, $tag_mm, ($tag_dd + ($sv_max_disp_week * 7) - 1) , $tag_yyyy) );

		//個別カウンセラーを求める
		$Mstaff_cnt = 0;
		if( $err_flg == 0 ){
			$query = 'select STAFF_CD,DECODE(STAFF_NM,"' . $ANGpw . '"),DECODE(OPEN_STAFF_NM,"' . $ANGpw . '"),ST_DATE,ED_DATE from M_STAFF where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and (CLASS_CD1 = "KBT" || CLASS_CD2 = "KBT" || CLASS_CD3 = "KBT" || CLASS_CD4 = "KBT" || CLASS_CD5 = "KBT" ) and YUKOU_FLG = 1 and !( ED_DATE < "' . $disp_st_date . '" && ST_DATE > "' . $disp_ed_date . '" ) order by ST_DATE,STAFF_CD;';
			$result = mysql_query($query);
			if (!$result) {
				$err_flg = 4;
				//エラーメッセージ表示
				require( './zs_errgmn.php' );
				
				//**ログ出力**
				$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
				$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
				$log_office_cd = $office_cd;	//オフィスコード
				$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
				$log_naiyou = 'スタッフマスタの参照に失敗しました。';	//内容
				$log_err_inf = $query;			//エラー情報
				require( './zs_log.php' );
				//************
				
			}else{
				while( $row = mysql_fetch_array($result) ){
					$Mstaff_staff_cd[$Mstaff_cnt] = $row[0];		//スタッフコード
					$Mstaff_staff_nm[$Mstaff_cnt] = $row[1];		//スタッフ名
					$Mstaff_open_staff_nm[$Mstaff_cnt] = $row[2];	//公開スタッフ名
					$Mstaff_st_date[$Mstaff_cnt] = substr($row[3],0,4) . substr($row[3],5,2) . substr($row[3],8,2);		//開始日
					$Mstaff_ed_date[$Mstaff_cnt] = substr($row[4],0,4) . substr($row[4],5,2) . substr($row[4],8,2);		//終了日
					$Mstaff_cnt++;
				}
			}
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
				
				print('<table border="0"');
				print('<tr>');
				print('<td width="185" align="left" valign="top">');
				//「会場」
				print('<img src="./img_' . $lang_cd . '/bar_kaijyou.png" border="0"><br>');
				print('<font size="2" color="blue">' . $Moffice_office_nm . '</font>');
				print('</td>');
				//戻るボタン
				print('<td width="135" align="right" valign="top">');
				if( $mobile_kbn == 'I' ){
					//iPhoneのみ
					print('<form method="post" action="' . $sv_https_adr . 'yoyaku_mb/M-kbt_counseling_select_top.php#kbtcounseling">');
				}else{
					print('<form method="post" action="' . $sv_https_adr . 'yoyaku_mb/M-kbt_counseling_select_top.php">');
				}
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '">');
				print('<input type="hidden" name="yykkey_ang_str" value="' . $yykkey_ang_str . '">');
				print('<input type="hidden" name="kaiin_id" value="' . $kaiin_id . '">');
				print('<input type="hidden" name="kaiin_nm" value="' . $kaiin_nm . '">');
				print('<input type="hidden" name="kaiin_kbn" value="' . $kaiin_kbn . '">');
				print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
				$tabindex++;
				print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" border="0">');
				print('</form>');
				print('</td>');
				print('</tr>');
				print('</table>');

				print('<hr>');

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
				print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');

				//「カウンセラーを選んでください」
				print('<img src="./img_' . $lang_cd . '/title_select_counselor.png" border="0"><br>');

				print('<table border="0">');
				print('<tr>');
				print('<td align="left" valign="top">');
				print('<img src="./img_' . $lang_cd . '/bar_counselor_180.png" border="0">');
				print('</td>');
				print('</tr>');
				print('<tr>');
				print('<td width="320" align="left" valign="middle">');
				print('<select name="select_staff_cd" style="font-size:24px; width:100%; background-color: #E0FFFF;">');
				print('<option value=""');
				if( $select_staff_cd == "" ){
					print(' selected');
				}
				print('>(指名なし)&nbsp;&nbsp;&nbsp;</option>');
				$i = 0;
				while( $i < $Mstaff_cnt ){
					print('<option value="' . $Mstaff_staff_cd[$i] . '"');
					if( $Mstaff_staff_cd[$i] == $select_staff_cd ){
						print(' selected');
					}
					print('>' . $Mstaff_open_staff_nm[$i] . '&nbsp;&nbsp;&nbsp;</option>');
					$i++;
				}
				print('</select>');
				print('</td>');			
				print('</tr>');
				print('<tr>');
				print('<td align="right" valign="middle">');
				$tabindex++;
				print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_next_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_next_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_next_1.png\';" border="0">');
				print('</td>');
				print('</tr>');
				print('</table>');
				
				print('</form>');

				print('<hr>');

				//戻るボタン
				print('<table border="0">');
				print('<tr>');
				print('<td width="185">&nbsp;</td>');
				print('<td width="135" align="center" valign="middle">');
				if( $mobile_kbn == 'I' ){
					//iPhoneのみ
					print('<form method="post" action="' . $sv_https_adr . 'yoyaku_mb/M-kbt_counseling_select_top.php#kbtcounseling">');
				}else{
					print('<form method="post" action="' . $sv_https_adr . 'yoyaku_mb/M-kbt_counseling_select_top.php">');
				}
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '">');
				print('<input type="hidden" name="yykkey_ang_str" value="' . $yykkey_ang_str . '">');
				print('<input type="hidden" name="kaiin_id" value="' . $kaiin_id . '">');
				print('<input type="hidden" name="kaiin_nm" value="' . $kaiin_nm . '">');
				print('<input type="hidden" name="kaiin_kbn" value="' . $kaiin_kbn . '">');
				print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');

				$tabindex++;
				print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" border="0">');
				print('</form>');
				print('</td>');
				print('</tr>');
				print('</table>');

				print('</td>');	//main
				print('</tr>');	//main
				print('</table>');	//main
			
				print('<hr>');
				
			}
			
			print('</center>');

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